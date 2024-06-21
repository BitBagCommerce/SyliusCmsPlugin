<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621093611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_cms_block_content (id INT AUTO_INCREMENT NOT NULL, block_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, configuration JSON NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_FAA763A8E9ED820C (block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_cms_block_content ADD CONSTRAINT FK_FAA763A8E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id)');
        $this->addSql('ALTER TABLE bitbag_cms_block ADD name VARCHAR(250) DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_block_translation DROP name, DROP link');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bitbag_cms_block_content DROP FOREIGN KEY FK_FAA763A8E9ED820C');
        $this->addSql('DROP TABLE bitbag_cms_block_content');
        $this->addSql('ALTER TABLE bitbag_cms_block_translation ADD name VARCHAR(255) DEFAULT NULL, ADD link LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_block DROP name');
    }
}
