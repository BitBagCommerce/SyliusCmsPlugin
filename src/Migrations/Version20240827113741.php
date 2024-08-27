<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240827113741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Renames tables without losing data';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_block_taxons DROP FOREIGN KEY FK_E324C6CEDE13F470');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxons DROP FOREIGN KEY FK_E324C6CEE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_faq_translation DROP FOREIGN KEY FK_8B30DD2E2C2AC5D3');
        $this->addSql('ALTER TABLE bitbag_cms_page_channels DROP FOREIGN KEY FK_DCA426972F5A1AA');
        $this->addSql('ALTER TABLE bitbag_cms_page_channels DROP FOREIGN KEY FK_DCA4269C4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_block_channels DROP FOREIGN KEY FK_8417B07372F5A1AA');
        $this->addSql('ALTER TABLE bitbag_cms_block_channels DROP FOREIGN KEY FK_8417B073E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_products_in_taxons DROP FOREIGN KEY FK_DAA9DD18E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_products_in_taxons DROP FOREIGN KEY FK_DAA9DD18DE13F470');
        $this->addSql('ALTER TABLE bitbag_cms_media_products DROP FOREIGN KEY FK_91A7DAC24584665A');
        $this->addSql('ALTER TABLE bitbag_cms_media_products DROP FOREIGN KEY FK_91A7DAC2EA9FDD75');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages DROP FOREIGN KEY FK_C96225EEC4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages DROP FOREIGN KEY FK_C96225EED823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_media_translation DROP FOREIGN KEY FK_1FEC58972C2AC5D3');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation DROP FOREIGN KEY FK_FDD074A62C2AC5D3');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks DROP FOREIGN KEY FK_A9D9C974D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks DROP FOREIGN KEY FK_A9D9C974E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089F4584665A');
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089FE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_page DROP FOREIGN KEY FK_18F07F1BF56F16CF');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales DROP FOREIGN KEY FK_E1F907BAE559DFD1');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales DROP FOREIGN KEY FK_E1F907BAE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_section_media DROP FOREIGN KEY FK_833A6197D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_media DROP FOREIGN KEY FK_833A6197EA9FDD75');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration DROP FOREIGN KEY FK_D899EFA7E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration DROP FOREIGN KEY FK_D899EFA7C4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels DROP FOREIGN KEY FK_D109622E72F5A1AA');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels DROP FOREIGN KEY FK_D109622EEA9FDD75');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels DROP FOREIGN KEY FK_FF6D59AC72F5A1AA');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels DROP FOREIGN KEY FK_FF6D59AC81BEC8C2');

        $this->addSql('RENAME TABLE bitbag_cms_template TO sylius_cms_template');
        $this->addSql('RENAME TABLE bitbag_cms_media TO sylius_cms_media');
        $this->addSql('RENAME TABLE bitbag_cms_block TO sylius_cms_block');
        $this->addSql('RENAME TABLE bitbag_cms_block_taxons TO sylius_cms_block_taxons');
        $this->addSql('RENAME TABLE bitbag_cms_page_channels TO sylius_cms_page_channels');
        $this->addSql('RENAME TABLE bitbag_cms_block_channels TO sylius_cms_block_channels');
        $this->addSql('RENAME TABLE bitbag_cms_block_products_in_taxons TO sylius_cms_block_products_in_taxons');
        $this->addSql('RENAME TABLE bitbag_cms_section_pages TO sylius_cms_section_pages');
        $this->addSql('RENAME TABLE bitbag_cms_media_translation TO sylius_cms_media_translation');
        $this->addSql('RENAME TABLE bitbag_cms_page_translation TO sylius_cms_page_translation');
        $this->addSql('RENAME TABLE bitbag_cms_section_blocks TO sylius_cms_section_blocks');
        $this->addSql('RENAME TABLE bitbag_cms_block_products TO sylius_cms_block_products');
        $this->addSql('RENAME TABLE bitbag_cms_page TO sylius_cms_page');
        $this->addSql('RENAME TABLE bitbag_cms_section TO sylius_cms_section');
        $this->addSql('RENAME TABLE bitbag_cms_block_locales TO sylius_cms_block_locales');
        $this->addSql('RENAME TABLE bitbag_cms_section_media TO sylius_cms_section_media');
        $this->addSql('RENAME TABLE bitbag_cms_content_configuration TO sylius_cms_content_configuration');
        $this->addSql('RENAME TABLE bitbag_cms_media_channels TO sylius_cms_media_channels');

        $this->addSql('ALTER TABLE sylius_cms_block_channels ADD CONSTRAINT FK_7026602FE9ED820C FOREIGN KEY (block_id) REFERENCES sylius_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_channels ADD CONSTRAINT FK_7026602F72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_locales ADD CONSTRAINT FK_49C0AACE9ED820C FOREIGN KEY (block_id) REFERENCES sylius_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_locales ADD CONSTRAINT FK_49C0AACE559DFD1 FOREIGN KEY (locale_id) REFERENCES sylius_locale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_products ADD CONSTRAINT FK_3088D8C3E9ED820C FOREIGN KEY (block_id) REFERENCES sylius_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_products ADD CONSTRAINT FK_3088D8C34584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_taxons ADD CONSTRAINT FK_5397DD03E9ED820C FOREIGN KEY (block_id) REFERENCES sylius_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_taxons ADD CONSTRAINT FK_5397DD03DE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_products_in_taxons ADD CONSTRAINT FK_B4D0B7CEE9ED820C FOREIGN KEY (block_id) REFERENCES sylius_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_products_in_taxons ADD CONSTRAINT FK_B4D0B7CEDE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_content_configuration ADD CONSTRAINT FK_BB97608DE9ED820C FOREIGN KEY (block_id) REFERENCES sylius_cms_block (id)');
        $this->addSql('ALTER TABLE sylius_cms_content_configuration ADD CONSTRAINT FK_BB97608DC4663E4 FOREIGN KEY (page_id) REFERENCES sylius_cms_page (id)');
        $this->addSql('ALTER TABLE sylius_cms_media_channels ADD CONSTRAINT FK_2538B272EA9FDD75 FOREIGN KEY (media_id) REFERENCES sylius_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_media_channels ADD CONSTRAINT FK_2538B27272F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_media_translation ADD CONSTRAINT FK_AAAC4A922C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_page ADD CONSTRAINT FK_2C2740B2F56F16CF FOREIGN KEY (teaser_image_id) REFERENCES sylius_cms_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sylius_cms_page_channels ADD CONSTRAINT FK_E8AF4F7FC4663E4 FOREIGN KEY (page_id) REFERENCES sylius_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_page_channels ADD CONSTRAINT FK_E8AF4F7F72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_page_translation ADD CONSTRAINT FK_6D0D401B2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_section_pages ADD CONSTRAINT FK_2C0728F8D823E37A FOREIGN KEY (section_id) REFERENCES sylius_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_section_pages ADD CONSTRAINT FK_2C0728F8C4663E4 FOREIGN KEY (page_id) REFERENCES sylius_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_section_blocks ADD CONSTRAINT FK_5DE81928D823E37A FOREIGN KEY (section_id) REFERENCES sylius_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_section_blocks ADD CONSTRAINT FK_5DE81928E9ED820C FOREIGN KEY (block_id) REFERENCES sylius_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_section_media ADD CONSTRAINT FK_665F6C81D823E37A FOREIGN KEY (section_id) REFERENCES sylius_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_section_media ADD CONSTRAINT FK_665F6C81EA9FDD75 FOREIGN KEY (media_id) REFERENCES sylius_cms_media (id) ON DELETE CASCADE');

        $this->addSql('DROP TABLE bitbag_cms_faq_translation');
        $this->addSql('DROP TABLE bitbag_cms_media_products');
        $this->addSql('DROP TABLE bitbag_cms_faq');
        $this->addSql('DROP TABLE bitbag_cms_faq_channels');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_cms_block_channels DROP FOREIGN KEY FK_7026602FE9ED820C');
        $this->addSql('ALTER TABLE sylius_cms_block_channels DROP FOREIGN KEY FK_7026602F72F5A1AA');
        $this->addSql('ALTER TABLE sylius_cms_block_locales DROP FOREIGN KEY FK_49C0AACE9ED820C');
        $this->addSql('ALTER TABLE sylius_cms_block_locales DROP FOREIGN KEY FK_49C0AACE559DFD1');
        $this->addSql('ALTER TABLE sylius_cms_block_products DROP FOREIGN KEY FK_3088D8C3E9ED820C');
        $this->addSql('ALTER TABLE sylius_cms_block_products DROP FOREIGN KEY FK_3088D8C34584665A');
        $this->addSql('ALTER TABLE sylius_cms_block_taxons DROP FOREIGN KEY FK_5397DD03E9ED820C');
        $this->addSql('ALTER TABLE sylius_cms_block_taxons DROP FOREIGN KEY FK_5397DD03DE13F470');
        $this->addSql('ALTER TABLE sylius_cms_block_products_in_taxons DROP FOREIGN KEY FK_B4D0B7CEE9ED820C');
        $this->addSql('ALTER TABLE sylius_cms_block_products_in_taxons DROP FOREIGN KEY FK_B4D0B7CEDE13F470');
        $this->addSql('ALTER TABLE sylius_cms_content_configuration DROP FOREIGN KEY FK_BB97608DE9ED820C');
        $this->addSql('ALTER TABLE sylius_cms_content_configuration DROP FOREIGN KEY FK_BB97608DC4663E4');
        $this->addSql('ALTER TABLE sylius_cms_media_channels DROP FOREIGN KEY FK_2538B272EA9FDD75');
        $this->addSql('ALTER TABLE sylius_cms_media_channels DROP FOREIGN KEY FK_2538B27272F5A1AA');
        $this->addSql('ALTER TABLE sylius_cms_media_translation DROP FOREIGN KEY FK_AAAC4A922C2AC5D3');
        $this->addSql('ALTER TABLE sylius_cms_page DROP FOREIGN KEY FK_2C2740B2F56F16CF');
        $this->addSql('ALTER TABLE sylius_cms_page_channels DROP FOREIGN KEY FK_E8AF4F7FC4663E4');
        $this->addSql('ALTER TABLE sylius_cms_page_channels DROP FOREIGN KEY FK_E8AF4F7F72F5A1AA');
        $this->addSql('ALTER TABLE sylius_cms_page_translation DROP FOREIGN KEY FK_6D0D401B2C2AC5D3');
        $this->addSql('ALTER TABLE sylius_cms_section_pages DROP FOREIGN KEY FK_2C0728F8D823E37A');
        $this->addSql('ALTER TABLE sylius_cms_section_pages DROP FOREIGN KEY FK_2C0728F8C4663E4');
        $this->addSql('ALTER TABLE sylius_cms_section_blocks DROP FOREIGN KEY FK_5DE81928D823E37A');
        $this->addSql('ALTER TABLE sylius_cms_section_blocks DROP FOREIGN KEY FK_5DE81928E9ED820C');
        $this->addSql('ALTER TABLE sylius_cms_section_media DROP FOREIGN KEY FK_665F6C81D823E37A');
        $this->addSql('ALTER TABLE sylius_cms_section_media DROP FOREIGN KEY FK_665F6C81EA9FDD75');

        $this->addSql('RENAME TABLE sylius_cms_template TO bitbag_cms_template');
        $this->addSql('RENAME TABLE sylius_cms_media TO bitbag_cms_media');
        $this->addSql('RENAME TABLE sylius_cms_block TO bitbag_cms_block');
        $this->addSql('RENAME TABLE sylius_cms_block_taxons TO bitbag_cms_block_taxons');
        $this->addSql('RENAME TABLE sylius_cms_page_channels TO bitbag_cms_page_channels');
        $this->addSql('RENAME TABLE sylius_cms_block_channels TO bitbag_cms_block_channels');
        $this->addSql('RENAME TABLE sylius_cms_block_products_in_taxons TO bitbag_cms_block_products_in_taxons');
        $this->addSql('RENAME TABLE sylius_cms_section_pages TO bitbag_cms_section_pages');
        $this->addSql('RENAME TABLE sylius_cms_media_translation TO bitbag_cms_media_translation');
        $this->addSql('RENAME TABLE sylius_cms_page_translation TO bitbag_cms_page_translation');
        $this->addSql('RENAME TABLE sylius_cms_section_blocks TO bitbag_cms_section_blocks');
        $this->addSql('RENAME TABLE sylius_cms_block_products TO bitbag_cms_block_products');
        $this->addSql('RENAME TABLE sylius_cms_page TO bitbag_cms_page');
        $this->addSql('RENAME TABLE sylius_cms_section TO bitbag_cms_section');
        $this->addSql('RENAME TABLE sylius_cms_block_locales TO bitbag_cms_block_locales');
        $this->addSql('RENAME TABLE sylius_cms_section_media TO bitbag_cms_section_media');
        $this->addSql('RENAME TABLE sylius_cms_content_configuration TO bitbag_cms_content_configuration');
        $this->addSql('RENAME TABLE sylius_cms_media_channels TO bitbag_cms_media_channels');

        $this->addSql('ALTER TABLE bitbag_cms_block_taxons ADD CONSTRAINT FK_E324C6CEDE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxons ADD CONSTRAINT FK_E324C6CEE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_channels ADD CONSTRAINT FK_DCA426972F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_channels ADD CONSTRAINT FK_DCA4269C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_channels ADD CONSTRAINT FK_8417B07372F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_channels ADD CONSTRAINT FK_8417B073E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products_in_taxons ADD CONSTRAINT FK_DAA9DD18E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products_in_taxons ADD CONSTRAINT FK_DAA9DD18DE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages ADD CONSTRAINT FK_C96225EEC4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages ADD CONSTRAINT FK_C96225EED823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_translation ADD CONSTRAINT FK_1FEC58972C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation ADD CONSTRAINT FK_FDD074A62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks ADD CONSTRAINT FK_A9D9C974D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks ADD CONSTRAINT FK_A9D9C974E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089F4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089FE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page ADD CONSTRAINT FK_18F07F1BF56F16CF FOREIGN KEY (teaser_image_id) REFERENCES bitbag_cms_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales ADD CONSTRAINT FK_E1F907BAE559DFD1 FOREIGN KEY (locale_id) REFERENCES sylius_locale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales ADD CONSTRAINT FK_E1F907BAE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_media ADD CONSTRAINT FK_833A6197D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_media ADD CONSTRAINT FK_833A6197EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration ADD CONSTRAINT FK_D899EFA7E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id)');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration ADD CONSTRAINT FK_D899EFA7C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id)');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels ADD CONSTRAINT FK_D109622E72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels ADD CONSTRAINT FK_D109622EEA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');

        $this->addSql('CREATE TABLE bitbag_cms_faq_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, question LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, answer LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, INDEX IDX_8B30DD2E2C2AC5D3 (translatable_id), UNIQUE INDEX bitbag_cms_faq_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_media_products (media_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_91A7DAC2EA9FDD75 (media_id), INDEX IDX_91A7DAC24584665A (product_id), PRIMARY KEY(media_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_faq (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, position INT NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_faq_channels (faq_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_FF6D59AC81BEC8C2 (faq_id), INDEX IDX_FF6D59AC72F5A1AA (channel_id), PRIMARY KEY(faq_id, channel_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');

        $this->addSql('ALTER TABLE bitbag_cms_faq_translation ADD CONSTRAINT FK_8B30DD2E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_faq (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_products ADD CONSTRAINT FK_91A7DAC24584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_products ADD CONSTRAINT FK_91A7DAC2EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels ADD CONSTRAINT FK_FF6D59AC72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels ADD CONSTRAINT FK_FF6D59AC81BEC8C2 FOREIGN KEY (faq_id) REFERENCES bitbag_cms_faq (id) ON DELETE CASCADE');
    }
}
