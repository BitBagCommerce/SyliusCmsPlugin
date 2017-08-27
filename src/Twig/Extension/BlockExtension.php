<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Twig\Extension;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Exception\TemplateTypeNotFound;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockExtension extends \Twig_Extension
{
    const BLOCK_TEXT_TEMPLATE = 'BitBagCmsPlugin:Block:textBlock.html.twig';
    const BLOCK_IMAGE_TEMPLATE = 'BitBagCmsPlugin:Block:imageBlock.html.twig';

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param BlockRepositoryInterface $blockRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        LoggerInterface $logger
    )
    {
        $this->blockRepository = $blockRepository;
        $this->logger = $logger;
    }

    /**
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('bitbag_render_block', [$this, 'renderBlock'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new \Twig_SimpleFunction('bitbag_block', [$this, 'block']),
        ];
    }

    /**
     * @param string $code
     *
     * @return BlockInterface|string
     */
    public function block($code)
    {
        $block = $this->blockRepository->findOneByCode($code);

        if (false === $block instanceof BlockInterface) {

            return null;
        }

        return $block;
    }

    /**
     * @param \Twig_Environment $twigEnvironment
     * @param string $code
     *
     * @return string|null
     * @throws TemplateTypeNotFound
     */
    public function renderBlock(\Twig_Environment $twigEnvironment, $code)
    {
        $block = $this->blockRepository->findOneByCode($code);

        if (false === $block instanceof BlockInterface) {

            $this->logger->warning(sprintf(
                'Block with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        if (BlockInterface::TEXT_BLOCK_TYPE === $block->getType()) {

            return $twigEnvironment->render(self::BLOCK_TEXT_TEMPLATE, ['block' => $block]);
        }

        if (BlockInterface::IMAGE_BLOCK_TYPE === $block->getType()) {

            return $twigEnvironment->render(self::BLOCK_IMAGE_TEMPLATE, ['block' => $block]);
        }

        throw new TemplateTypeNotFound($block->getType());
    }
}