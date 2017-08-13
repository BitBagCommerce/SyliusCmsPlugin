<?php

namespace BitBag\CmsPlugin\Entity;

use Sylius\Component\Resource\Model\TranslatableTrait;

final class Block implements BlockInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->initializeTranslationsCollection();
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $code;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return  $this->id;
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation()
    {
        return new BlockTranslation();
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        $this->getTranslation()->getContent();
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->getTranslation()->setContent($content);
    }
}