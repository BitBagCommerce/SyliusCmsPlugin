<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Templating\Helper;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Exception\BlockNotFoundException;
use BitBag\CmsPlugin\Exception\TemplateTypeNotFound;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\Helper\Helper;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class BlockHelper extends Helper implements BlockHelperInterface
{
    const BLOCK_TEXT_TEMPLATE = 'BitBagCmsPlugin:Block:textBlock.html.twig';
    const BLOCK_IMAGE_TEMPLATE = 'BitBagCmsPlugin:Block:imageBlock.html.twig';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityRepository
     */
    private $blockRepository;

    /**
     * @param ContainerInterface $container
     * @param EntityRepository $blockRepository
     */
    public function __construct(ContainerInterface $container, EntityRepository $blockRepository)
    {
        $this->blockRepository = $blockRepository;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function renderBlock($code)
    {
        /** @var BlockInterface $block */
        $block = $this->blockRepository->findOneBy(['code' => $code]);

        if ($block === null) {
            throw new BlockNotFoundException($code);
        }

        $twigEngine = $this->container->get('templating');

        switch ($block->getType()) {
            case BlockInterface::TEXT_BLOCK_TYPE:

                return $twigEngine->render(self::BLOCK_TEXT_TEMPLATE, [
                    'data' => $block,
                ]);
            case BlockInterface::IMAGE_BLOCK_TYPE:

                return $twigEngine->render(self::BLOCK_IMAGE_TEMPLATE, [
                    'data' => $block,
                ]);
            default:
                throw new TemplateTypeNotFound($block->getType());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'bitbag_cms_plugin_block';
    }
}