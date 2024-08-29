<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240730084203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration creates the bitbag_cms_template table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(250) DEFAULT NULL, type VARCHAR(250) DEFAULT NULL, content_elements JSON NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE bitbag_cms_template');
    }
}
