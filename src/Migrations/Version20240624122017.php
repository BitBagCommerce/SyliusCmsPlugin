<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624122017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_cms_block_locales (block_id INT NOT NULL, locale_id INT NOT NULL, INDEX IDX_E1F907BAE9ED820C (block_id), INDEX IDX_E1F907BAE559DFD1 (locale_id), PRIMARY KEY(block_id, locale_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_block_content (id INT AUTO_INCREMENT NOT NULL, block_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, configuration JSON NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_FAA763A8E9ED820C (block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales ADD CONSTRAINT FK_E1F907BAE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales ADD CONSTRAINT FK_E1F907BAE559DFD1 FOREIGN KEY (locale_id) REFERENCES sylius_locale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_content ADD CONSTRAINT FK_FAA763A8E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id)');
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089F4584665A');
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089FE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies DROP FOREIGN KEY FK_10C3E429E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies DROP FOREIGN KEY FK_10C3E429DE13F470');
        $this->addSql('ALTER TABLE bitbag_cms_block_translation DROP FOREIGN KEY FK_32897FDF2C2AC5D3');
        $this->addSql('DROP TABLE bitbag_cms_block_products');
        $this->addSql('DROP TABLE bitbag_cms_block_taxonomies');
        $this->addSql('DROP TABLE bitbag_cms_block_translation');
        $this->addSql('ALTER TABLE bitbag_cms_block ADD name VARCHAR(250) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_cms_block_products (block_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_C4B9089FE9ED820C (block_id), INDEX IDX_C4B9089F4584665A (product_id), PRIMARY KEY(block_id, product_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_block_taxonomies (block_id INT NOT NULL, taxon_id INT NOT NULL, INDEX IDX_10C3E429E9ED820C (block_id), INDEX IDX_10C3E429DE13F470 (taxon_id), PRIMARY KEY(block_id, taxon_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_block_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, content LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, link LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_32897FDF2C2AC5D3 (translatable_id), UNIQUE INDEX bitbag_cms_block_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089F4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089FE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies ADD CONSTRAINT FK_10C3E429E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxonomies ADD CONSTRAINT FK_10C3E429DE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_translation ADD CONSTRAINT FK_32897FDF2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales DROP FOREIGN KEY FK_E1F907BAE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_locales DROP FOREIGN KEY FK_E1F907BAE559DFD1');
        $this->addSql('ALTER TABLE bitbag_cms_block_content DROP FOREIGN KEY FK_FAA763A8E9ED820C');
        $this->addSql('DROP TABLE bitbag_cms_block_locales');
        $this->addSql('DROP TABLE bitbag_cms_block_content');
        $this->addSql('ALTER TABLE bitbag_cms_block DROP name');
    }
}
