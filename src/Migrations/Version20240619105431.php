<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619105431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE temp_bitbag_cms_block_sections AS SELECT * FROM bitbag_cms_block_sections');
        $this->addSql('CREATE TABLE temp_bitbag_cms_media_sections AS SELECT * FROM bitbag_cms_media_sections');
        $this->addSql('CREATE TABLE temp_bitbag_cms_page_sections AS SELECT * FROM bitbag_cms_page_sections');
        $this->addSql('CREATE TABLE temp_bitbag_cms_section_translation AS SELECT * FROM bitbag_cms_section_translation');
        $this->addSql('CREATE TABLE temp_bitbag_cms_section_pages AS SELECT * FROM bitbag_cms_section_pages');
        $this->addSql('CREATE TABLE temp_bitbag_cms_section_blocks AS SELECT * FROM bitbag_cms_section_blocks');
        $this->addSql('CREATE TABLE temp_bitbag_cms_section_media AS SELECT * FROM bitbag_cms_section_media');
        $this->addSql('CREATE TABLE temp_bitbag_cms_section AS SELECT * FROM bitbag_cms_section');

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_cms_block_collections (block_id INT NOT NULL, collection_id INT NOT NULL, INDEX IDX_55C5E95EE9ED820C (block_id), INDEX IDX_55C5E95E514956FD (collection_id), PRIMARY KEY(block_id, collection_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_collection (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(250) NOT NULL, type VARCHAR(250) DEFAULT NULL, UNIQUE INDEX UNIQ_9634175177153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_collection_pages (collection_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_3989329D514956FD (collection_id), INDEX IDX_3989329DC4663E4 (page_id), PRIMARY KEY(collection_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_collection_blocks (collection_id INT NOT NULL, block_id INT NOT NULL, INDEX IDX_602502E5514956FD (collection_id), INDEX IDX_602502E5E9ED820C (block_id), PRIMARY KEY(collection_id, block_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_collection_media (collection_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_73D176E4514956FD (collection_id), INDEX IDX_73D176E4EA9FDD75 (media_id), PRIMARY KEY(collection_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_collection_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_1250294C2C2AC5D3 (translatable_id), UNIQUE INDEX bitbag_cms_collection_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_media_collections (media_id INT NOT NULL, collection_id INT NOT NULL, INDEX IDX_78A0CE16EA9FDD75 (media_id), INDEX IDX_78A0CE16514956FD (collection_id), PRIMARY KEY(media_id, collection_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_page_collections (block_id INT NOT NULL, collection_id INT NOT NULL, INDEX IDX_9A9CE227E9ED820C (block_id), INDEX IDX_9A9CE227514956FD (collection_id), PRIMARY KEY(block_id, collection_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_cms_block_collections ADD CONSTRAINT FK_55C5E95EE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_collections ADD CONSTRAINT FK_55C5E95E514956FD FOREIGN KEY (collection_id) REFERENCES bitbag_cms_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_collection_pages ADD CONSTRAINT FK_3989329D514956FD FOREIGN KEY (collection_id) REFERENCES bitbag_cms_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_collection_pages ADD CONSTRAINT FK_3989329DC4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_collection_blocks ADD CONSTRAINT FK_602502E5514956FD FOREIGN KEY (collection_id) REFERENCES bitbag_cms_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_collection_blocks ADD CONSTRAINT FK_602502E5E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_collection_media ADD CONSTRAINT FK_73D176E4514956FD FOREIGN KEY (collection_id) REFERENCES bitbag_cms_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_collection_media ADD CONSTRAINT FK_73D176E4EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_collection_translation ADD CONSTRAINT FK_1250294C2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_collections ADD CONSTRAINT FK_78A0CE16EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_collections ADD CONSTRAINT FK_78A0CE16514956FD FOREIGN KEY (collection_id) REFERENCES bitbag_cms_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_collections ADD CONSTRAINT FK_9A9CE227E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_collections ADD CONSTRAINT FK_9A9CE227514956FD FOREIGN KEY (collection_id) REFERENCES bitbag_cms_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections DROP FOREIGN KEY FK_5C95115DE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections DROP FOREIGN KEY FK_5C95115DD823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections DROP FOREIGN KEY FK_98BC300EA9FDD75');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections DROP FOREIGN KEY FK_98BC300D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections DROP FOREIGN KEY FK_D548E347D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections DROP FOREIGN KEY FK_D548E347E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_section_translation DROP FOREIGN KEY FK_F99CA8582C2AC5D3');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages DROP FOREIGN KEY FK_C96225EEC4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages DROP FOREIGN KEY FK_C96225EED823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks DROP FOREIGN KEY FK_A9D9C974D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks DROP FOREIGN KEY FK_A9D9C974E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_section_media DROP FOREIGN KEY FK_833A6197EA9FDD75');
        $this->addSql('ALTER TABLE bitbag_cms_section_media DROP FOREIGN KEY FK_833A6197D823E37A');
        $this->addSql('DROP TABLE bitbag_cms_block_sections');
        $this->addSql('DROP TABLE bitbag_cms_media_sections');
        $this->addSql('DROP TABLE bitbag_cms_page_sections');
        $this->addSql('DROP TABLE bitbag_cms_section_translation');
        $this->addSql('DROP TABLE bitbag_cms_section_pages');
        $this->addSql('DROP TABLE bitbag_cms_section_blocks');
        $this->addSql('DROP TABLE bitbag_cms_section_media');
        $this->addSql('DROP TABLE bitbag_cms_section');

        $this->addSql('INSERT INTO bitbag_cms_block_collections (block_id, collection_id) SELECT block_id, section_id FROM temp_bitbag_cms_block_sections');
        $this->addSql('INSERT INTO bitbag_cms_collection (id, code, type) SELECT id, code, type FROM temp_bitbag_cms_section');
        $this->addSql('INSERT INTO bitbag_cms_collection_pages (collection_id, page_id) SELECT section_id, page_id FROM temp_bitbag_cms_section_pages');
        $this->addSql('INSERT INTO bitbag_cms_collection_blocks (collection_id, block_id) SELECT section_id, block_id FROM temp_bitbag_cms_section_blocks');
        $this->addSql('INSERT INTO bitbag_cms_collection_media (collection_id, media_id) SELECT section_id, media_id FROM temp_bitbag_cms_section_media');
        $this->addSql('INSERT INTO bitbag_cms_collection_translation (translatable_id, name, locale) SELECT translatable_id, name, locale FROM temp_bitbag_cms_section_translation');
        $this->addSql('INSERT INTO bitbag_cms_media_collections (media_id, collection_id) SELECT media_id, section_id FROM temp_bitbag_cms_media_sections');
        $this->addSql('INSERT INTO bitbag_cms_page_collections (block_id, collection_id) SELECT block_id, section_id FROM temp_bitbag_cms_page_sections');

        $this->addSql('DROP TABLE temp_bitbag_cms_block_sections');
        $this->addSql('DROP TABLE temp_bitbag_cms_media_sections');
        $this->addSql('DROP TABLE temp_bitbag_cms_page_sections');
        $this->addSql('DROP TABLE temp_bitbag_cms_section_translation');
        $this->addSql('DROP TABLE temp_bitbag_cms_section_pages');
        $this->addSql('DROP TABLE temp_bitbag_cms_section_blocks');
        $this->addSql('DROP TABLE temp_bitbag_cms_section_media');
        $this->addSql('DROP TABLE temp_bitbag_cms_section');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE temp_bitbag_cms_block_collections AS SELECT * FROM bitbag_cms_block_collections');
        $this->addSql('CREATE TABLE temp_bitbag_cms_media_collections AS SELECT * FROM bitbag_cms_media_collections');
        $this->addSql('CREATE TABLE temp_bitbag_cms_page_collections AS SELECT * FROM bitbag_cms_page_collections');
        $this->addSql('CREATE TABLE temp_bitbag_cms_collection_translation AS SELECT * FROM bitbag_cms_collection_translation');
        $this->addSql('CREATE TABLE temp_bitbag_cms_collection_pages AS SELECT * FROM bitbag_cms_collection_pages');
        $this->addSql('CREATE TABLE temp_bitbag_cms_collection_blocks AS SELECT * FROM bitbag_cms_collection_blocks');
        $this->addSql('CREATE TABLE temp_bitbag_cms_collection_media AS SELECT * FROM bitbag_cms_collection_media');
        $this->addSql('CREATE TABLE temp_bitbag_cms_collection AS SELECT * FROM bitbag_cms_collection');

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_cms_block_sections (block_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_5C95115DE9ED820C (block_id), INDEX IDX_5C95115DD823E37A (section_id), PRIMARY KEY(block_id, section_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_media_sections (media_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_98BC300D823E37A (section_id), INDEX IDX_98BC300EA9FDD75 (media_id), PRIMARY KEY(media_id, section_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_page_sections (block_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_D548E347D823E37A (section_id), INDEX IDX_D548E347E9ED820C (block_id), PRIMARY KEY(block_id, section_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_section_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, locale VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_F99CA8582C2AC5D3 (translatable_id), UNIQUE INDEX bitbag_cms_section_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_section_pages (section_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_C96225EED823E37A (section_id), INDEX IDX_C96225EEC4663E4 (page_id), PRIMARY KEY(section_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_section_blocks (section_id INT NOT NULL, block_id INT NOT NULL, INDEX IDX_A9D9C974D823E37A (section_id), INDEX IDX_A9D9C974E9ED820C (block_id), PRIMARY KEY(section_id, block_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_section_media (section_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_833A6197EA9FDD75 (media_id), INDEX IDX_833A6197D823E37A (section_id), PRIMARY KEY(section_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_section (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(250) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, type VARCHAR(250) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_421D079777153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections ADD CONSTRAINT FK_5C95115DE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections ADD CONSTRAINT FK_5C95115DD823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections ADD CONSTRAINT FK_98BC300EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections ADD CONSTRAINT FK_98BC300D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections ADD CONSTRAINT FK_D548E347D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections ADD CONSTRAINT FK_D548E347E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_translation ADD CONSTRAINT FK_F99CA8582C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages ADD CONSTRAINT FK_C96225EEC4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages ADD CONSTRAINT FK_C96225EED823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks ADD CONSTRAINT FK_A9D9C974D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks ADD CONSTRAINT FK_A9D9C974E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_media ADD CONSTRAINT FK_833A6197EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_media ADD CONSTRAINT FK_833A6197D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_collections DROP FOREIGN KEY FK_55C5E95EE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_collections DROP FOREIGN KEY FK_55C5E95E514956FD');
        $this->addSql('ALTER TABLE bitbag_cms_collection_pages DROP FOREIGN KEY FK_3989329D514956FD');
        $this->addSql('ALTER TABLE bitbag_cms_collection_pages DROP FOREIGN KEY FK_3989329DC4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_collection_blocks DROP FOREIGN KEY FK_602502E5514956FD');
        $this->addSql('ALTER TABLE bitbag_cms_collection_blocks DROP FOREIGN KEY FK_602502E5E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_collection_media DROP FOREIGN KEY FK_73D176E4514956FD');
        $this->addSql('ALTER TABLE bitbag_cms_collection_media DROP FOREIGN KEY FK_73D176E4EA9FDD75');
        $this->addSql('ALTER TABLE bitbag_cms_collection_translation DROP FOREIGN KEY FK_1250294C2C2AC5D3');
        $this->addSql('ALTER TABLE bitbag_cms_media_collections DROP FOREIGN KEY FK_78A0CE16EA9FDD75');
        $this->addSql('ALTER TABLE bitbag_cms_media_collections DROP FOREIGN KEY FK_78A0CE16514956FD');
        $this->addSql('ALTER TABLE bitbag_cms_page_collections DROP FOREIGN KEY FK_9A9CE227E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_page_collections DROP FOREIGN KEY FK_9A9CE227514956FD');
        $this->addSql('DROP TABLE bitbag_cms_block_collections');
        $this->addSql('DROP TABLE bitbag_cms_collection');
        $this->addSql('DROP TABLE bitbag_cms_collection_pages');
        $this->addSql('DROP TABLE bitbag_cms_collection_blocks');
        $this->addSql('DROP TABLE bitbag_cms_collection_media');
        $this->addSql('DROP TABLE bitbag_cms_collection_translation');
        $this->addSql('DROP TABLE bitbag_cms_media_collections');
        $this->addSql('DROP TABLE bitbag_cms_page_collections');

        $this->addSql('INSERT INTO bitbag_cms_block_sections (block_id, section_id) SELECT block_id, collection_id FROM temp_bitbag_cms_block_collections');
        $this->addSql('INSERT INTO bitbag_cms_media_sections (media_id, section_id) SELECT media_id, collection_id FROM temp_bitbag_cms_media_collections');
        $this->addSql('INSERT INTO bitbag_cms_page_sections (block_id, section_id) SELECT block_id, collection_id FROM temp_bitbag_cms_page_collections');
        $this->addSql('INSERT INTO bitbag_cms_section_translation (translatable_id, name, locale) SELECT translatable_id, name, locale FROM temp_bitbag_cms_collection_translation');
        $this->addSql('INSERT INTO bitbag_cms_section_pages (section_id, page_id) SELECT section_id, collection_id FROM temp_bitbag_cms_collection_pages');
        $this->addSql('INSERT INTO bitbag_cms_section_blocks (section_id, block_id) SELECT section_id, collection_id FROM temp_bitbag_cms_collection_blocks');
        $this->addSql('INSERT INTO bitbag_cms_section_media (section_id, media_id) SELECT section_id, collection_id FROM temp_bitbag_cms_collection_media');
        $this->addSql('INSERT INTO bitbag_cms_section (id, code, type) SELECT id, code, type FROM temp_bitbag_cms_collection');

        $this->addSql('DROP TABLE temp_bitbag_cms_block_collections');
        $this->addSql('DROP TABLE temp_bitbag_cms_media_collections');
        $this->addSql('DROP TABLE temp_bitbag_cms_page_collections');
        $this->addSql('DROP TABLE temp_bitbag_cms_collection_translation');
        $this->addSql('DROP TABLE temp_bitbag_cms_collection_pages');
        $this->addSql('DROP TABLE temp_bitbag_cms_collection_blocks');
        $this->addSql('DROP TABLE temp_bitbag_cms_collection_media');
        $this->addSql('DROP TABLE temp_bitbag_cms_collection');
    }
}
