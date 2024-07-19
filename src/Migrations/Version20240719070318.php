<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240719070318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_cms_block_products (block_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_C4B9089FE9ED820C (block_id), INDEX IDX_C4B9089F4584665A (product_id), PRIMARY KEY(block_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_block_taxons (block_id INT NOT NULL, taxon_id INT NOT NULL, INDEX IDX_E324C6CEE9ED820C (block_id), INDEX IDX_E324C6CEDE13F470 (taxon_id), PRIMARY KEY(block_id, taxon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_block_products_in_taxons (block_id INT NOT NULL, taxon_id INT NOT NULL, INDEX IDX_DAA9DD18E9ED820C (block_id), INDEX IDX_DAA9DD18DE13F470 (taxon_id), PRIMARY KEY(block_id, taxon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089FE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products ADD CONSTRAINT FK_C4B9089F4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxons ADD CONSTRAINT FK_E324C6CEE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxons ADD CONSTRAINT FK_E324C6CEDE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products_in_taxons ADD CONSTRAINT FK_DAA9DD18E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_products_in_taxons ADD CONSTRAINT FK_DAA9DD18DE13F470 FOREIGN KEY (taxon_id) REFERENCES sylius_taxon (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089FE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_products DROP FOREIGN KEY FK_C4B9089F4584665A');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxons DROP FOREIGN KEY FK_E324C6CEE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_taxons DROP FOREIGN KEY FK_E324C6CEDE13F470');
        $this->addSql('ALTER TABLE bitbag_cms_block_products_in_taxons DROP FOREIGN KEY FK_DAA9DD18E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_products_in_taxons DROP FOREIGN KEY FK_DAA9DD18DE13F470');
        $this->addSql('DROP TABLE bitbag_cms_block_products');
        $this->addSql('DROP TABLE bitbag_cms_block_taxons');
        $this->addSql('DROP TABLE bitbag_cms_block_products_in_taxons');
    }
}
