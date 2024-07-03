<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240701100702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration adds possibility to add content elements into blocks and pages. Unused tables are removed.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_block_locales (block_id INT NOT NULL, locale_id INT NOT NULL, INDEX IDX_E1F907BAE9ED820C (block_id), INDEX IDX_E1F907BAE559DFD1 (locale_id), PRIMARY KEY(block_id, locale_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_content_configuration (id INT AUTO_INCREMENT NOT NULL, block_id INT DEFAULT NULL, page_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, configuration JSON NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_D899EFA7E9ED820C (block_id), INDEX IDX_D899EFA7C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_page_locales (page_id INT NOT NULL, locale_id INT NOT NULL, INDEX IDX_EF20FD23C4663E4 (page_id), INDEX IDX_EF20FD23E559DFD1 (locale_id), PRIMARY KEY(page_id, locale_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales ADD CONSTRAINT FK_E1F907BAE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales ADD CONSTRAINT FK_E1F907BAE559DFD1 FOREIGN KEY (locale_id) REFERENCES sylius_locale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration ADD CONSTRAINT FK_D899EFA7E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id)');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration ADD CONSTRAINT FK_D899EFA7C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id)');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales ADD CONSTRAINT FK_EF20FD23C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales ADD CONSTRAINT FK_EF20FD23E559DFD1 FOREIGN KEY (locale_id) REFERENCES sylius_locale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies DROP FOREIGN KEY FK_10C3E429DE13F470');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies DROP FOREIGN KEY FK_10C3E429E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_page_products DROP FOREIGN KEY FK_4D64FA854584665A');
        $this->addSql('ALTER TABLE bitbag_cms_page_products DROP FOREIGN KEY FK_4D64FA85C4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089F4584665A');
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089FE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_translation DROP FOREIGN KEY FK_32897FDF2C2AC5D3');
        $this->addSql('DROP TABLE bitbag_cms_block_taxonomies');
        $this->addSql('DROP TABLE bitbag_cms_page_products');
        $this->addSql('DROP TABLE bitbag_cms_block_products');
        $this->addSql('DROP TABLE bitbag_cms_block_translation');
        $this->addSql('ALTER TABLE bitbag_cms_block ADD name VARCHAR(250) DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_page ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation DROP FOREIGN KEY FK_FDD074A63DA5256D');
        $this->addSql('DROP INDEX IDX_FDD074A63DA5256D ON bitbag_cms_page_translation');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation DROP image_id, DROP name, DROP breadcrumb, DROP name_when_linked, DROP description_when_linked, DROP content');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_block_taxonomies (block_id INT NOT NULL, taxon_id INT NOT NULL, INDEX IDX_10C3E429E9ED820C (block_id), INDEX IDX_10C3E429DE13F470 (taxon_id), PRIMARY KEY(block_id, taxon_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_page_products (page_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_4D64FA85C4663E4 (page_id), INDEX IDX_4D64FA854584665A (product_id), PRIMARY KEY(page_id, product_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_block_products (block_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_C4B9089FE9ED820C (block_id), INDEX IDX_C4B9089F4584665A (product_id), PRIMARY KEY(block_id, product_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_block_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, content LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, link LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_32897FDF2C2AC5D3 (translatable_id), UNIQUE INDEX bitbag_cms_block_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies ADD CONSTRAINT FK_10C3E429DE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies ADD CONSTRAINT FK_10C3E429E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_products ADD CONSTRAINT FK_4D64FA854584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_products ADD CONSTRAINT FK_4D64FA85C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089F4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089FE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_translation ADD CONSTRAINT FK_32897FDF2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales DROP FOREIGN KEY FK_E1F907BAE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales DROP FOREIGN KEY FK_E1F907BAE559DFD1');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration DROP FOREIGN KEY FK_D899EFA7E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration DROP FOREIGN KEY FK_D899EFA7C4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales DROP FOREIGN KEY FK_EF20FD23C4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales DROP FOREIGN KEY FK_EF20FD23E559DFD1');
        $this->addSql('DROP TABLE bitbag_cms_block_locales');
        $this->addSql('DROP TABLE bitbag_cms_content_configuration');
        $this->addSql('DROP TABLE bitbag_cms_page_locales');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation ADD image_id INT DEFAULT NULL, ADD name VARCHAR(255) DEFAULT NULL, ADD breadcrumb VARCHAR(255) DEFAULT NULL, ADD name_when_linked VARCHAR(255) DEFAULT NULL, ADD description_when_linked VARCHAR(1000) DEFAULT NULL, ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation ADD CONSTRAINT FK_FDD074A63DA5256D FOREIGN KEY (image_id) REFERENCES bitbag_cms_media (id)');
        $this->addSql('CREATE INDEX IDX_FDD074A63DA5256D ON bitbag_cms_page_translation (image_id)');
        $this->addSql('ALTER TABLE bitbag_cms_block DROP name');
        $this->addSql('ALTER TABLE bitbag_cms_page DROP name');
    }
}
