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
use Sylius\Component\Resource\Model\TranslationInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
class Page extends AbstractTranslation implements PageInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $metaKeywords;

    /**
     * @var string
     */
    protected $metaDescription;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var ArrayCollection|ProductInterface[]
     */
    protected $products;

    public function __construct()
    {
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
     * @param mixed $id
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
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param mixed $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
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
}