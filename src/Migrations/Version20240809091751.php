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

final class Version20240809091751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration fixes relation between Page/Media/Block and Collection Entities.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_block_sections DROP FOREIGN KEY FK_5C95115DD823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections DROP FOREIGN KEY FK_5C95115DE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections DROP FOREIGN KEY FK_D548E347D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections DROP FOREIGN KEY FK_D548E347E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections DROP FOREIGN KEY FK_98BC300D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections DROP FOREIGN KEY FK_98BC300EA9FDD75');
        $this->addSql('DROP TABLE bitbag_cms_block_sections');
        $this->addSql('DROP TABLE bitbag_cms_page_sections');
        $this->addSql('DROP TABLE bitbag_cms_media_sections');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_block_sections (block_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_5C95115DE9ED820C (block_id), INDEX IDX_5C95115DD823E37A (section_id), PRIMARY KEY(block_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_page_sections (block_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_D548E347D823E37A (section_id), INDEX IDX_D548E347E9ED820C (block_id), PRIMARY KEY(block_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_media_sections (media_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_98BC300EA9FDD75 (media_id), INDEX IDX_98BC300D823E37A (section_id), PRIMARY KEY(media_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections ADD CONSTRAINT FK_5C95115DD823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections ADD CONSTRAINT FK_5C95115DE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections ADD CONSTRAINT FK_D548E347D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections ADD CONSTRAINT FK_D548E347E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections ADD CONSTRAINT FK_98BC300D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections ADD CONSTRAINT FK_98BC300EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
    }
}
