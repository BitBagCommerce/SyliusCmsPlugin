<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240725064430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration remove locales from pages.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_page_locales DROP FOREIGN KEY FK_EF20FD23C4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales DROP FOREIGN KEY FK_EF20FD23E559DFD1');
        $this->addSql('DROP TABLE bitbag_cms_page_locales');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_page_locales (page_id INT NOT NULL, locale_id INT NOT NULL, INDEX IDX_EF20FD23E559DFD1 (locale_id), INDEX IDX_EF20FD23C4663E4 (page_id), PRIMARY KEY(page_id, locale_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales ADD CONSTRAINT FK_EF20FD23C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales ADD CONSTRAINT FK_EF20FD23E559DFD1 FOREIGN KEY (locale_id) REFERENCES sylius_locale (id) ON DELETE CASCADE');
    }
}
