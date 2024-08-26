<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230524102024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial CMS Plugin migration version';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_block (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(64) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_321C84CF77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_block_channels (block_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_8417B073E9ED820C (block_id), INDEX IDX_8417B07372F5A1AA (channel_id), PRIMARY KEY(block_id, channel_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_block_products (block_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_C4B9089F4584665A (product_id), INDEX IDX_C4B9089FE9ED820C (block_id), PRIMARY KEY(block_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_block_sections (block_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_5C95115DD823E37A (section_id), INDEX IDX_5C95115DE9ED820C (block_id), PRIMARY KEY(block_id, section_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_block_taxonomies (block_id INT NOT NULL, taxon_id INT NOT NULL, INDEX IDX_10C3E429E9ED820C (block_id), INDEX IDX_10C3E429DE13F470 (taxon_id), PRIMARY KEY(block_id, taxon_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_block_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, link LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX bitbag_cms_block_translation_uniq_trans (translatable_id, locale), INDEX IDX_32897FDF2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_faq (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, position INT NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_faq_channels (faq_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_FF6D59AC81BEC8C2 (faq_id), INDEX IDX_FF6D59AC72F5A1AA (channel_id), PRIMARY KEY(faq_id, channel_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_faq_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, question LONGTEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, answer LONGTEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX bitbag_cms_faq_translation_uniq_trans (translatable_id, locale), INDEX IDX_8B30DD2E2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_media (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(250) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, type VARCHAR(250) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, path VARCHAR(250) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, mime_type VARCHAR(250) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, enabled TINYINT(1) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, UNIQUE INDEX UNIQ_DB2BB2E177153098 (code), UNIQUE INDEX UNIQ_DB2BB2E1B548B0F (path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_media_channels (block_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_D109622EE9ED820C (block_id), INDEX IDX_D109622E72F5A1AA (channel_id), PRIMARY KEY(block_id, channel_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_media_products (media_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_91A7DAC2EA9FDD75 (media_id), INDEX IDX_91A7DAC24584665A (product_id), PRIMARY KEY(media_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_media_sections (media_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_98BC300EA9FDD75 (media_id), INDEX IDX_98BC300D823E37A (section_id), PRIMARY KEY(media_id, section_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_media_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, alt LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, link LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_1FEC58972C2AC5D3 (translatable_id), UNIQUE INDEX bitbag_cms_media_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_page (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(250) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, enabled TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, publish_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_18F07F1B77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_page_channels (page_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_DCA426972F5A1AA (channel_id), INDEX IDX_DCA4269C4663E4 (page_id), PRIMARY KEY(page_id, channel_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_page_products (page_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_4D64FA85C4663E4 (page_id), INDEX IDX_4D64FA854584665A (product_id), PRIMARY KEY(page_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_page_sections (block_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_D548E347E9ED820C (block_id), INDEX IDX_D548E347D823E37A (section_id), PRIMARY KEY(block_id, section_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_page_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, image_id INT DEFAULT NULL, slug VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, breadcrumb VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, name_when_linked VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, description_when_linked VARCHAR(1000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, meta_keywords VARCHAR(1000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, meta_description VARCHAR(5000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, title VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_FDD074A63DA5256D (image_id), UNIQUE INDEX bitbag_cms_page_translation_uniq_trans (translatable_id, locale), INDEX IDX_FDD074A62C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_section (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(250) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_421D079777153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_section_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX bitbag_cms_section_translation_uniq_trans (translatable_id, locale), INDEX IDX_F99CA8582C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections ADD CONSTRAINT FK_5C95115DE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections ADD CONSTRAINT FK_5C95115DD823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089FE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089F4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies ADD CONSTRAINT FK_10C3E429E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies ADD CONSTRAINT FK_10C3E429DE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_channels ADD CONSTRAINT FK_8417B073E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_channels ADD CONSTRAINT FK_8417B07372F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_translation ADD CONSTRAINT FK_32897FDF2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels ADD CONSTRAINT FK_FF6D59AC81BEC8C2 FOREIGN KEY (faq_id) REFERENCES bitbag_cms_faq (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels ADD CONSTRAINT FK_FF6D59AC72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_faq_translation ADD CONSTRAINT FK_8B30DD2E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_faq (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections ADD CONSTRAINT FK_98BC300EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections ADD CONSTRAINT FK_98BC300D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_products ADD CONSTRAINT FK_91A7DAC2EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_products ADD CONSTRAINT FK_91A7DAC24584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels ADD CONSTRAINT FK_D109622EE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels ADD CONSTRAINT FK_D109622E72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_translation ADD CONSTRAINT FK_1FEC58972C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections ADD CONSTRAINT FK_D548E347E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections ADD CONSTRAINT FK_D548E347D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_products ADD CONSTRAINT FK_4D64FA85C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_products ADD CONSTRAINT FK_4D64FA854584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_channels ADD CONSTRAINT FK_DCA4269C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_channels ADD CONSTRAINT FK_DCA426972F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation ADD CONSTRAINT FK_FDD074A62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation ADD CONSTRAINT FK_FDD074A63DA5256D FOREIGN KEY (image_id) REFERENCES bitbag_cms_media (id)');
        $this->addSql('ALTER TABLE bitbag_cms_section_translation ADD CONSTRAINT FK_F99CA8582C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_block_sections DROP FOREIGN KEY FK_5C95115DE9ED820C ');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections DROP FOREIGN KEY FK_5C95115DD823E37A ');
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089FE9ED820C ');
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089F4584665A ');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies DROP FOREIGN KEY FK_10C3E429E9ED820C ');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies DROP FOREIGN KEY FK_10C3E429DE13F470 ');
        $this->addSql('ALTER TABLE bitbag_cms_block_channels DROP FOREIGN KEY FK_8417B073E9ED820C ');
        $this->addSql('ALTER TABLE bitbag_cms_block_channels DROP FOREIGN KEY FK_8417B07372F5A1AA ');
        $this->addSql('ALTER TABLE bitbag_cms_block_translation DROP FOREIGN KEY FK_32897FDF2C2AC5D3 ');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels DROP FOREIGN KEY FK_FF6D59AC81BEC8C2 ');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels DROP FOREIGN KEY FK_FF6D59AC72F5A1AA ');
        $this->addSql('ALTER TABLE bitbag_cms_faq_translation DROP FOREIGN KEY FK_8B30DD2E2C2AC5D3 ');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections DROP FOREIGN KEY FK_98BC300EA9FDD75 ');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections DROP FOREIGN KEY FK_98BC300D823E37A ');
        $this->addSql('ALTER TABLE bitbag_cms_media_products DROP FOREIGN KEY FK_91A7DAC2EA9FDD75 ');
        $this->addSql('ALTER TABLE bitbag_cms_media_products DROP FOREIGN KEY FK_91A7DAC24584665A ');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels DROP FOREIGN KEY FK_D109622EE9ED820C ');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels DROP FOREIGN KEY FK_D109622E72F5A1AA ');
        $this->addSql('ALTER TABLE bitbag_cms_media_translation DROP FOREIGN KEY FK_1FEC58972C2AC5D3 ');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections DROP FOREIGN KEY FK_D548E347E9ED820C ');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections DROP FOREIGN KEY FK_D548E347D823E37A ');
        $this->addSql('ALTER TABLE bitbag_cms_page_products DROP FOREIGN KEY FK_4D64FA85C4663E4 ');
        $this->addSql('ALTER TABLE bitbag_cms_page_products DROP FOREIGN KEY FK_4D64FA854584665A ');
        $this->addSql('ALTER TABLE bitbag_cms_page_channels DROP FOREIGN KEY FK_DCA4269C4663E4 ');
        $this->addSql('ALTER TABLE bitbag_cms_page_channels DROP FOREIGN KEY FK_DCA426972F5A1AA ');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation DROP FOREIGN KEY FK_FDD074A62C2AC5D3 ');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation DROP FOREIGN KEY FK_FDD074A63DA5256D');
        $this->addSql('ALTER TABLE bitbag_cms_section_translation DROP FOREIGN KEY FK_F99CA8582C2AC5D3 ');
        $this->addSql('DROP TABLE bitbag_cms_block');
        $this->addSql('DROP TABLE bitbag_cms_block_channels');
        $this->addSql('DROP TABLE bitbag_cms_block_products');
        $this->addSql('DROP TABLE bitbag_cms_block_sections');
        $this->addSql('DROP TABLE bitbag_cms_block_taxonomies');
        $this->addSql('DROP TABLE bitbag_cms_block_translation');
        $this->addSql('DROP TABLE bitbag_cms_faq');
        $this->addSql('DROP TABLE bitbag_cms_faq_channels');
        $this->addSql('DROP TABLE bitbag_cms_faq_translation');
        $this->addSql('DROP TABLE bitbag_cms_media');
        $this->addSql('DROP TABLE bitbag_cms_media_channels');
        $this->addSql('DROP TABLE bitbag_cms_media_products');
        $this->addSql('DROP TABLE bitbag_cms_media_sections');
        $this->addSql('DROP TABLE bitbag_cms_media_translation');
        $this->addSql('DROP TABLE bitbag_cms_page');
        $this->addSql('DROP TABLE bitbag_cms_page_channels');
        $this->addSql('DROP TABLE bitbag_cms_page_products');
        $this->addSql('DROP TABLE bitbag_cms_page_sections');
        $this->addSql('DROP TABLE bitbag_cms_page_translation');
        $this->addSql('DROP TABLE bitbag_cms_section');
        $this->addSql('DROP TABLE bitbag_cms_section_translation');
    }
}
