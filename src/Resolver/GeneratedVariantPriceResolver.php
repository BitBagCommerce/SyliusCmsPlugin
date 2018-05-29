<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Dictionary\SupportOptionDictionary;
use BitBag\SyliusCmsPlugin\Dictionary\UpdateSubscriptionOptionDictionary;
use BitBag\SyliusCmsPlugin\Entity\ProductInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Webmozart\Assert\Assert;

final class GeneratedVariantPriceResolver implements GeneratedVariantPriceResolverInterface
{
    /** @var FactoryInterface */
    private $channelPricingFactory;

    /** @var ChannelContextInterface */
    private $channelContext;

    public function __construct(FactoryInterface $channelPricingFactory, ChannelContextInterface $channelContext)
    {
        $this->channelPricingFactory = $channelPricingFactory;
        $this->channelContext = $channelContext;
    }

    public function resolvePrice(ProductVariantInterface $productVariant): void
    {
        /** @var ProductInterface $product */
        $product = $productVariant->getProduct();
        $price = $product->getBasePrice() * 100;

        foreach ($productVariant->getOptionValues() as $optionValue) {
            $optionCode = $optionValue->getOption()->getCode();
            $optionValueCode = $optionValue->getCode();

            if (UpdateSubscriptionOptionDictionary::OPTION_CODE === $optionCode) {
                Assert::keyExists(UpdateSubscriptionOptionDictionary::SUBSCRIPTION_TIME_MAP, $optionValueCode);
                $multiplier = array_search($optionValueCode, array_keys(UpdateSubscriptionOptionDictionary::SUBSCRIPTION_TIME_MAP));

                $price = $price + (100 * $multiplier * self::BASE_SUBSCRIPTION_PRICE);
            }

            if (SupportOptionDictionary::OPTION_CODE === $optionCode) {
                Assert::keyExists(SupportOptionDictionary::SUPPORT_HOURS_MAP, $optionValueCode);
                $multiplier = SupportOptionDictionary::SUPPORT_HOURS_MAP[$optionValueCode];

                $price = $price + (100 * $multiplier * self::BASE_MAN_HOUR_PRICE);
            }
        }

        /** @var ChannelPricingInterface $channelPricing */
        $channelPricing = $this->channelPricingFactory->createNew();
        $channelPricing->setChannelCode($this->channelContext->getChannel()->getCode());
        $channelPricing->setPrice($price);

        $productVariant->addChannelPricing($channelPricing);
    }
}
