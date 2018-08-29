<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Parser;

use Webmozart\Assert\Assert;

final class ContentParser implements ContentParserInterface
{
    /** @var \Twig_Environment */
    private $twigEnvironment;

    /** @var array */
    private $enabledFunctions;

    public function __construct(\Twig_Environment $twigEnvironment, array $enabledFunctions)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->enabledFunctions = $enabledFunctions;
    }

    public function parse(string $input): string
    {
        $functions = $this->twigEnvironment->getFunctions();

        preg_match_all('`{{\s*(?P<method>.+)\s*\((?P<arguments>.*)\)\s*}}`', $input, $callMatches);

        foreach ($callMatches[0] as $index => $call) {
            $function = $callMatches['method'][$index];
            if (!in_array($function, $this->enabledFunctions)) {
                continue;
            }

            if (null !== $arguments = $this->getFunctionArguments($function, $call)) {
                try {
                    $functionResult = $this->callFunction($functions, $function, $arguments);
                } catch (\Exception $exception) {
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
        $functionParts = explode($start, $input);

        if (isset($functionParts[1])) {
            $functionParts = explode($end, $functionParts[1]);
            $arguments = explode(',', $functionParts[0]);

            return array_map(function (string $element): string {
                return trim(trim($element), '\'');
            }, $arguments);
        }

        return null;
    }

    private function callFunction(array $functions, string $functionName, array $arguments): string
    {
        Assert::keyExists($functions, $functionName, sprintf('Function %s does not exist!', $functionName));
        /** @var \Twig_Function $function */
        $function = $functions[$functionName];
        $callable = $function->getCallable();
        $extension = $callable[0];
        $extensionMethod = $callable[1];

        return call_user_func_array([$extension, $extensionMethod], $arguments);
    }
}
