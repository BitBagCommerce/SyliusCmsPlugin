<?php

namespace Tests\BitBag\SyliusCmsPlugin\Api\Sitemap\Provider;

use Lakion\ApiTestCase\XmlApiTestCase;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Currency\Model\Currency;
use Sylius\Component\Currency\Model\CurrencyInterface;
use Sylius\Component\Locale\Model\Locale;
use Sylius\Component\Locale\Model\LocaleInterface;

abstract class AbstractTestController extends XmlApiTestCase
{

    /**
     * @var ChannelInterface
     */
    protected $channel;

    /**
     * @var LocaleInterface
     */
    protected $locale;

    /**
     * @var LocaleInterface
     */
    protected $locale2;

    /**
     * @var CurrencyInterface
     */
    protected $currency;

    /**
     * @before
     */
    public function setupDatabase()
    {
        parent::setUpDatabase();

        $this->locale = new Locale();
        $this->locale->setCode('en_US');

        $this->getEntityManager()->persist($this->locale);

        $this->locale2 = new Locale();
        $this->locale2->setCode('nl_NL');

        $this->getEntityManager()->persist($this->locale2);

        $this->currency = new Currency();
        $this->currency->setCode('USD');

        $this->getEntityManager()->persist($this->currency);

        $this->channel = new Channel();
        $this->channel->setCode('US_WEB');
        $this->channel->setName('US Web Store');
        $this->channel->setDefaultLocale($this->locale);
        $this->channel->setBaseCurrency($this->currency);
        $this->channel->setTaxCalculationStrategy('order_items_based');

        $this->channel->addLocale($this->locale);
        $this->channel->addLocale($this->locale2);

        $this->getEntityManager()->persist($this->channel);
        $this->getEntityManager()->flush();
    }

}
