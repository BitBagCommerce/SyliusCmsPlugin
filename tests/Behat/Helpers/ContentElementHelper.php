<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Helpers;

final class ContentElementHelper
{
    public static function getDefinedElementThatShouldAppearAfterSelectContentElement(string $contentElement): string
    {
        return match ($contentElement) {
            'Textarea' => 'content_elements_textarea',
            'Single media' => 'content_elements_single_media_dropdown',
            'Multiple media' => 'content_elements_multiple_media_dropdown',
            'Heading' => 'content_elements_heading',
            'Products carousel' => 'content_elements_products_carousel',
            'Products carousel by Taxon' => 'content_elements_products_carousel_by_taxon',
            'Taxons list' => 'content_elements_taxons_list',
            default => throw new \InvalidArgumentException(sprintf('Content element with name "%s" does not exist.', $contentElement)),
        };
    }

    public static function getExampleConfigurationByContentElement(string $contentElement): array
    {
        return match ($contentElement) {
            'Textarea' => ['textarea' => 'Content'],
            'Single media' => ['single_media' => 'homepage_header_image'],
            'Multiple media' => ['multiple_media' => ['homepage_header_image', 'homepage_pdf']],
            'Heading' => ['heading_type' => 'h1', 'heading' => 'Heading content'],
            'Products carousel' => ['products_carousel' => [
                'products' => [
                    'Everyday_white_basic_T_Shirt',
                    'Loose_white_designer_T_Shirt',
                ],
            ]],
            'Products carousel by Taxon' => ['products_carousel_by_taxon' => 'MENU_CATEGORY'],
            'Taxons list' => ['taxons_list' => [
                'taxons' => [
                    'MENU_CATEGORY',
                    't_shirts',
                ],
            ]],
            default => throw new \InvalidArgumentException(sprintf('Content element with name "%s" does not exist.', $contentElement)),
        };
    }
}
