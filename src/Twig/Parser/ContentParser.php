<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Parser;

use Twig\Environment;
use Twig\TwigFunction;
use Webmozart\Assert\Assert;

final class ContentParser implements ContentParserInterface
{
    public function __construct(private Environment $twigEnvironment, private array $enabledFunctions)
    {
    }

    public function parse(string $input): string
    {
        $functions = $this->twigEnvironment->getFunctions();

        preg_match_all('`{{\s*(?P<method>[^\(]+)\s*\((?P<arguments>[^\)]*)\)\s*}}`', $input, $callMatches);

        foreach ($callMatches[0] as $index => $call) {
            $function = $callMatches['method'][$index];
            if (!in_array($function, $this->enabledFunctions, true)) {
                continue;
            }

            if (null !== $arguments = $this->getFunctionArguments($function, $call)) {
                try {
                    $functionResult = $this->callFunction($functions, $function, $arguments);
                } catch (\Exception) {
                    $functionResult = '';
                }

                $input = str_replace($call, $functionResult, $input);
            }
        }

        return $input;
    }

    private function getFunctionArguments(string $functionName, string $input): ?array
    {
        $start = '{{ ' . $functionName . '(';
        $end = ') }}';
        /** @var string[]|false $functionParts */
        $functionParts = explode($start, $input);

        if (false !== $functionParts && isset($functionParts[1])) {
            $functionParts = explode($end, $functionParts[1]);
            $arguments = explode(',', $functionParts[0]);

            return array_map(static function (string $element): string {
                return trim(trim($element), '\'');
            }, $arguments);
        }

        return null;
    }

    private function callFunction(
        array $functions,
        string $functionName,
        array $arguments,
    ): string {
        Assert::keyExists($functions, $functionName, sprintf('Function %s does not exist!', $functionName));
        /** @var TwigFunction $function */
        $function = $functions[$functionName];
        $callable = $function->getCallable();
        Assert::isArray($callable, sprintf('Function with name "%s" is not callable', $functionName));
        $extension = $callable[0];
        $extensionMethod = $callable[1];
        $callback = [$extension, $extensionMethod];
        Assert::isCallable($callback);

        return call_user_func_array($callback, $arguments);
    }
}
