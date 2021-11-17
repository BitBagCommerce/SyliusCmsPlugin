<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixer;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

final class AboveTwoArgumentsMultilineFixer implements FixerInterface
{
    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(\T_FUNCTION);
    }

    public function isRisky(): bool
    {
        return true;
    }

    public function fix(\SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = 0; $index < $tokens->count(); ++$index) {
            $variableTokenIndexes = [];
            $openBracketIndex = null;
            if ($tokens[$index]->isGivenKind(\T_FUNCTION)) {
                while (')' !== $tokens[$index]->getContent()) {
                    $currentToken = $tokens[$index];
                    if ($currentToken->isGivenKind(\T_VARIABLE)) {
                        $variableTokenIndexes[] = $index;
                    }
                    if ('(' === $currentToken->getContent()) {
                        $openBracketIndex = $index;
                    }
                    ++$index;
                }
                if (2 < count($variableTokenIndexes)) {
                    if (!$tokens[$openBracketIndex + 1]->isWhitespace()) {
                        $tokens[$openBracketIndex + 1] = new Token([\T_STRING, "\n        " . $tokens[$openBracketIndex + 1]->getContent()]);
                    }
                    foreach ($variableTokenIndexes as $variableTokensIndex) {
                        $currentIndex = $variableTokensIndex;
                        while (',' !== $tokens[$currentIndex]->getContent()) {
                            ++$currentIndex;
                            if (',' === $tokens[$currentIndex]->getContent() && '\n' !== $tokens[$currentIndex]->getContent()) {
                                $tokens[$currentIndex + 1] = new Token([\T_STRING, "\n        "]);
                            } elseif (')' === $tokens[$currentIndex]->getContent()) {
                                if (!$tokens[$currentIndex - 1]->isWhitespace()) {
                                    $tokens[$currentIndex - 1] = new Token([\T_STRING, $tokens[$currentIndex - 1]->getContent() . "\n    "]);
                                }

                                break;
                            }
                        }
                    }
                }
            }
        }
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Arguments in methods must be on multiple lines if there are more than two.',
            [
                new CodeSample(
                    'public function bar(
                        FirstParamInterface $firstParam, 
                        SecondParamInterface $secondParam,
                        ThirdParamInterface $thirdParam
                    ): void;'
                ),
            ]
        );
    }

    public function getName(): string
    {
        return self::class;
    }

    public function getPriority(): int
    {
        return -1000;
    }

    public function supports(\SplFileInfo $file): bool
    {
        return true;
    }
}
