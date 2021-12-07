<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\Controller\Helper\FormErrorsFlashHelperInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;

trait CommonSetterDependencyInjectionsTrait
{
    /** @var CacheManager */
    private $cacheManager;

    /** @var DataManager */
    private $dataManager;

    /** @var FormErrorsFlashHelperInterface */
    private $formErrorsFlashHelper;

    public function setFormErrorsFlashHelper(FormErrorsFlashHelperInterface $formErrorsFlashHelper): void
    {
        $this->formErrorsFlashHelper = $formErrorsFlashHelper;
    }

    public function setCacheManager(CacheManager $cacheManager): void
    {
        $this->cacheManager = $cacheManager;
    }

    public function setDataManager(DataManager $dataManager): void
    {
        $this->dataManager = $dataManager;
    }
}
