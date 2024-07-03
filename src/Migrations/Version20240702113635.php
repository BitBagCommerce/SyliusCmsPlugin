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

final class Version20240702113635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration removes the FAQ entity and its translations.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_faq_translation DROP FOREIGN KEY FK_8B30DD2E2C2AC5D3');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels DROP FOREIGN KEY FK_FF6D59AC81BEC8C2');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels DROP FOREIGN KEY FK_FF6D59AC72F5A1AA');
        $this->addSql('DROP TABLE bitbag_cms_faq_translation');
        $this->addSql('DROP TABLE bitbag_cms_faq');
        $this->addSql('DROP TABLE bitbag_cms_faq_channels');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_faq_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, question LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, answer LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX bitbag_cms_faq_translation_uniq_trans (translatable_id, locale), INDEX IDX_8B30DD2E2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_faq (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, position INT NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_faq_channels (faq_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_FF6D59AC72F5A1AA (channel_id), INDEX IDX_FF6D59AC81BEC8C2 (faq_id), PRIMARY KEY(faq_id, channel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_faq_translation ADD CONSTRAINT FK_8B30DD2E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_faq (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels ADD CONSTRAINT FK_FF6D59AC81BEC8C2 FOREIGN KEY (faq_id) REFERENCES bitbag_cms_faq (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_faq_channels ADD CONSTRAINT FK_FF6D59AC72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
    }
}
