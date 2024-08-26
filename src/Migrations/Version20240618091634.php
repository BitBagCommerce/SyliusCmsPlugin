<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240618091634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration adds possibility to select section type and fill up collection of items of this type.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_section_pages (section_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_C96225EED823E37A (section_id), INDEX IDX_C96225EEC4663E4 (page_id), PRIMARY KEY(section_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_section_blocks (section_id INT NOT NULL, block_id INT NOT NULL, INDEX IDX_A9D9C974D823E37A (section_id), INDEX IDX_A9D9C974E9ED820C (block_id), PRIMARY KEY(section_id, block_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_section_media (section_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_833A6197D823E37A (section_id), INDEX IDX_833A6197EA9FDD75 (media_id), PRIMARY KEY(section_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages ADD CONSTRAINT FK_C96225EED823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages ADD CONSTRAINT FK_C96225EEC4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks ADD CONSTRAINT FK_A9D9C974D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks ADD CONSTRAINT FK_A9D9C974E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_media ADD CONSTRAINT FK_833A6197D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_media ADD CONSTRAINT FK_833A6197EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section ADD type VARCHAR(250) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_section_pages DROP FOREIGN KEY FK_C96225EED823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages DROP FOREIGN KEY FK_C96225EEC4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks DROP FOREIGN KEY FK_A9D9C974D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks DROP FOREIGN KEY FK_A9D9C974E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_section_media DROP FOREIGN KEY FK_833A6197D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_media DROP FOREIGN KEY FK_833A6197EA9FDD75');
        $this->addSql('DROP TABLE bitbag_cms_section_pages');
        $this->addSql('DROP TABLE bitbag_cms_section_blocks');
        $this->addSql('DROP TABLE bitbag_cms_section_media');
        $this->addSql('ALTER TABLE bitbag_cms_section DROP type');
    }
}
