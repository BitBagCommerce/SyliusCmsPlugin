<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Model\AbstractTranslation;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
class Page extends AbstractTranslation implements PageInterface
{
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    use ToggleableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var ArrayCollection|ProductInterface[]
     */
    protected $products;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->products = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->getPageTranslation()->getSlug();
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->getPageTranslation()->setSlug($slug);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaKeywords()
    {
        return $this->getPageTranslation()->getMetaKeywords();
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->getPageTranslation()->setMetaKeywords($metaKeywords);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaDescription()
    {
        return $this->getPageTranslation()->getMetaDescription();
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaDescription($metaDescription)
    {
        $this->getPageTranslation()->setMetaDescription($metaDescription);
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->getPageTranslation()->getContent();
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->getPageTranslation()->setContent($content);
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function hasProduct(ProductInterface $product)
    {
        return $this->products->contains($product);
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(ProductInterface $product)
    {
        $this->products->add($product);
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(ProductInterface $product)
    {
        if (true === $this->hasProduct($product)) {
            $this->products->removeElement($product);
        }
    }

    /**
     * @return PageTranslationInterface|TranslationInterface
     */
    protected function getPageTranslation()
    {
        return $this->getTranslation();
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation()
    {
        return new PageTranslation();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getPageTranslation()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->getPageTranslation()->setName($name);
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
}