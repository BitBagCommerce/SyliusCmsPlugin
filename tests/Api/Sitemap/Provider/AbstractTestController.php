<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Api\Sitemap\Provider;

use ApiTestCase\XmlApiTestCase;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Currency\Model\Currency;
use Sylius\Component\Currency\Model\CurrencyInterface;
use Sylius\Component\Locale\Model\Locale;
use Sylius\Component\Locale\Model\LocaleInterface;

abstract class AbstractTestController extends XmlApiTestCase
{
    /** @var ChannelInterface */
    protected $channel;

    /** @var LocaleInterface */
    protected $locale;

    /** @var LocaleInterface */
    protected $secondLocale;

    /** @var CurrencyInterface */
    protected $currency;

    /**
     * @before
     */
    public function setupDatabase(): void
    {
        parent::setUpDatabase();

        $this->locale = new Locale();
        $this->locale->setCode('en_US');

        $this->getEntityManager()->persist($this->locale);

        $this->secondLocale = new Locale();
        $this->secondLocale->setCode('nl_NL');

        $this->getEntityManager()->persist($this->secondLocale);

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
        $this->channel->addLocale($this->secondLocale);

        $this->getEntityManager()->persist($this->channel);
        $this->getEntityManager()->flush();
    }
}
