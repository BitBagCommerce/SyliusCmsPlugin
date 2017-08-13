<?php

namespace BitBag\CmsPlugin\Templating\Helper;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Exception\BlockNotFoundException;
use BitBag\CmsPlugin\Exception\TemplateTypeNotFound;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\Helper\Helper;

final class BlockHelper extends Helper implements BlockHelperInterface
{
    const BLOCK_TEXT_TEMPLATE = 'BitBagCmsPlugin:Block:block_text.html.twig';

    const BLOCK_IMAGE_TEMPLATE = 'BitBagCmsPlugin:Block:block_image.html.twig';

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
                break;
            case BlockInterface::IMAGE_BLOCK_TYPE:
                return $twigEngine->render(self::BLOCK_IMAGE_TEMPLATE, [
                    'data' => $block,
                ]);
                break;
            default:
                throw new TemplateTypeNotFound($block->getType());
                break;
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