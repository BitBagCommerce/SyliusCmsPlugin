<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240916100051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration removes the sylius_cms_block_locales table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_cms_block_locales DROP FOREIGN KEY FK_49C0AACE559DFD1');
        $this->addSql('ALTER TABLE sylius_cms_block_locales DROP FOREIGN KEY FK_49C0AACE9ED820C');
        $this->addSql('DROP TABLE sylius_cms_block_locales');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE sylius_cms_block_locales (block_id INT NOT NULL, locale_id INT NOT NULL, INDEX IDX_49C0AACE9ED820C (block_id), INDEX IDX_49C0AACE559DFD1 (locale_id), PRIMARY KEY(block_id, locale_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sylius_cms_block_locales ADD CONSTRAINT FK_49C0AACE559DFD1 FOREIGN KEY (locale_id) REFERENCES sylius_locale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_cms_block_locales ADD CONSTRAINT FK_49C0AACE9ED820C FOREIGN KEY (block_id) REFERENCES sylius_cms_block (id) ON DELETE CASCADE');
    }
}
