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

final class Version20240701104206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration drops bitbag_cms_section_translation table and adds name column to bitbag_cms_section table. (Section -> Collection)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_section_translation DROP FOREIGN KEY FK_F99CA8582C2AC5D3');
        $this->addSql('DROP TABLE bitbag_cms_section_translation');
        $this->addSql('ALTER TABLE bitbag_cms_section ADD name VARCHAR(250) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_section_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_F99CA8582C2AC5D3 (translatable_id), UNIQUE INDEX bitbag_cms_section_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_section_translation ADD CONSTRAINT FK_F99CA8582C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section DROP name');
    }
}
