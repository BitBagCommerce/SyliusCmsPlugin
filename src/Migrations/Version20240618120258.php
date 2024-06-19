<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240618120258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Renames tables and preserves data during migration';
    }

    public function up(Schema $schema): void
    {
        // Back up data from the old tables
        $this->addSql('CREATE TABLE bitbag_cms_page_sections_backup AS SELECT * FROM bitbag_cms_page_sections');
        $this->addSql('CREATE TABLE bitbag_cms_block_sections_backup AS SELECT * FROM bitbag_cms_block_sections');
        $this->addSql('CREATE TABLE bitbag_cms_media_sections_backup AS SELECT * FROM bitbag_cms_media_sections');
        $this->addSql('CREATE TABLE bitbag_cms_section_translation_backup AS SELECT * FROM bitbag_cms_section_translation');
        $this->addSql('CREATE TABLE bitbag_cms_section_pages_backup AS SELECT * FROM bitbag_cms_section_pages');
        $this->addSql('CREATE TABLE bitbag_cms_section_blocks_backup AS SELECT * FROM bitbag_cms_section_blocks');
        $this->addSql('CREATE TABLE bitbag_cms_section_media_backup AS SELECT * FROM bitbag_cms_section_media');
        $this->addSql('CREATE TABLE bitbag_cms_section_backup AS SELECT * FROM bitbag_cms_section');

        // Perform the schema changes
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

        // Drop old tables
        $this->addSql('ALTER TABLE bitbag_cms_page_sections DROP FOREIGN KEY FK_D548E347E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections DROP FOREIGN KEY FK_D548E347D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections DROP FOREIGN KEY FK_5C95115DE9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections DROP FOREIGN KEY FK_5C95115DD823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections DROP FOREIGN KEY FK_98BC300D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections DROP FOREIGN KEY FK_98BC300EA9FDD75');
        $this->addSql('ALTER TABLE bitbag_cms_section_translation DROP FOREIGN KEY FK_F99CA8582C2AC5D3');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages DROP FOREIGN KEY FK_C96225EEC4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages DROP FOREIGN KEY FK_C96225EED823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks DROP FOREIGN KEY FK_A9D9C974E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks DROP FOREIGN KEY FK_A9D9C974D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_media DROP FOREIGN KEY FK_98406A0D823E37A');
        $this->addSql('ALTER TABLE bitbag_cms_section_media DROP FOREIGN KEY FK_98406A0EA9FDD75');

        $this->addSql('DROP TABLE bitbag_cms_page_sections');
        $this->addSql('DROP TABLE bitbag_cms_block_sections');
        $this->addSql('DROP TABLE bitbag_cms_media_sections');
        $this->addSql('DROP TABLE bitbag_cms_section_translation');
        $this->addSql('DROP TABLE bitbag_cms_section_pages');
        $this->addSql('DROP TABLE bitbag_cms_section_blocks');
        $this->addSql('DROP TABLE bitbag_cms_section_media');
        $this->addSql('DROP TABLE bitbag_cms_section');

        // Restore data to the new tables
        $this->addSql('INSERT INTO bitbag_cms_collection (id, code, type) SELECT id, code, type FROM bitbag_cms_section_backup');
        $this->addSql('INSERT INTO bitbag_cms_collection_translation (id, translatable_id, name, locale) SELECT id, translatable_id, name, locale FROM bitbag_cms_section_translation_backup');
        $this->addSql('INSERT INTO bitbag_cms_collection_pages (collection_id, page_id) SELECT section_id, page_id FROM bitbag_cms_section_pages_backup');
        $this->addSql('INSERT INTO bitbag_cms_collection_blocks (collection_id, block_id) SELECT section_id, block_id FROM bitbag_cms_section_blocks_backup');
        $this->addSql('INSERT INTO bitbag_cms_collection_media (collection_id, media_id) SELECT section_id, media_id FROM bitbag_cms_section_media_backup');
        $this->addSql('INSERT INTO bitbag_cms_page_collections (block_id, collection_id) SELECT page_id, section_id FROM bitbag_cms_page_sections_backup');
        $this->addSql('INSERT INTO bitbag_cms_block_collections (block_id, collection_id) SELECT block_id, section_id FROM bitbag_cms_block_sections_backup');
        $this->addSql('INSERT INTO bitbag_cms_media_collections (media_id, collection_id) SELECT media_id, section_id FROM bitbag_cms_media_sections_backup');

        // Drop the backup tables
        $this->addSql('DROP TABLE bitbag_cms_page_sections_backup');
        $this->addSql('DROP TABLE bitbag_cms_block_sections_backup');
        $this->addSql('DROP TABLE bitbag_cms_media_sections_backup');
        $this->addSql('DROP TABLE bitbag_cms_section_translation_backup');
        $this->addSql('DROP TABLE bitbag_cms_section_pages_backup');
        $this->addSql('DROP TABLE bitbag_cms_section_blocks_backup');
        $this->addSql('DROP TABLE bitbag_cms_section_media_backup');
        $this->addSql('DROP TABLE bitbag_cms_section_backup');
    }

    public function down(Schema $schema): void
    {
        // Back up data from the new tables
        $this->addSql('CREATE TABLE bitbag_cms_page_collections_backup AS SELECT * FROM bitbag_cms_page_collections');
        $this->addSql('CREATE TABLE bitbag_cms_block_collections_backup AS SELECT * FROM bitbag_cms_block_collections');
        $this->addSql('CREATE TABLE bitbag_cms_media_collections_backup AS SELECT * FROM bitbag_cms_media_collections');
        $this->addSql('CREATE TABLE bitbag_cms_collection_translation_backup AS SELECT * FROM bitbag_cms_collection_translation');
        $this->addSql('CREATE TABLE bitbag_cms_collection_pages_backup AS SELECT * FROM bitbag_cms_collection_pages');
        $this->addSql('CREATE TABLE bitbag_cms_collection_blocks_backup AS SELECT * FROM bitbag_cms_collection_blocks');
        $this->addSql('CREATE TABLE bitbag_cms_collection_media_backup AS SELECT * FROM bitbag_cms_collection_media');
        $this->addSql('CREATE TABLE bitbag_cms_collection_backup AS SELECT * FROM bitbag_cms_collection');

        // Restore the original table structures
        $this->addSql('CREATE TABLE bitbag_cms_page_sections (page_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_D548E347C4663E4 (page_id), INDEX IDX_D548E347D823E37A (section_id), PRIMARY KEY(page_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_block_sections (block_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_5C95115DE9ED820C (block_id), INDEX IDX_5C95115DD823E37A (section_id), PRIMARY KEY(block_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_media_sections (media_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_98BC300EA9FDD75 (media_id), INDEX IDX_98BC300D823E37A (section_id), PRIMARY KEY(media_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_section_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_F99CA8582C2AC5D3 (translatable_id), UNIQUE INDEX bitbag_cms_section_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_section_pages (section_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_C96225EEC4663E4 (page_id), INDEX IDX_C96225EED823E37A (section_id), PRIMARY KEY(section_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_section_blocks (section_id INT NOT NULL, block_id INT NOT NULL, INDEX IDX_A9D9C974E9ED820C (block_id), INDEX IDX_A9D9C974D823E37A (section_id), PRIMARY KEY(section_id, block_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_section_media (section_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_98406A0EA9FDD75 (media_id), INDEX IDX_98406A0D823E37A (section_id), PRIMARY KEY(section_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_section (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(250) NOT NULL, type VARCHAR(250) DEFAULT NULL, UNIQUE INDEX UNIQ_D7D8598F77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE bitbag_cms_page_sections ADD CONSTRAINT FK_D548E347E9ED820C FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_sections ADD CONSTRAINT FK_D548E347D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections ADD CONSTRAINT FK_5C95115DE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_sections ADD CONSTRAINT FK_5C95115DD823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections ADD CONSTRAINT FK_98BC300D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_sections ADD CONSTRAINT FK_98BC300EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_translation ADD CONSTRAINT FK_F99CA8582C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages ADD CONSTRAINT FK_C96225EEC4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_pages ADD CONSTRAINT FK_C96225EED823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks ADD CONSTRAINT FK_A9D9C974E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_blocks ADD CONSTRAINT FK_A9D9C974D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_media ADD CONSTRAINT FK_98406A0D823E37A FOREIGN KEY (section_id) REFERENCES bitbag_cms_section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_section_media ADD CONSTRAINT FK_98406A0EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');

        // Restore data to the original tables
        $this->addSql('INSERT INTO bitbag_cms_section (id, code, type) SELECT id, code, type FROM bitbag_cms_collection_backup');
        $this->addSql('INSERT INTO bitbag_cms_section_translation (id, translatable_id, name, locale) SELECT id, translatable_id, name, locale FROM bitbag_cms_collection_translation_backup');
        $this->addSql('INSERT INTO bitbag_cms_section_pages (section_id, page_id) SELECT collection_id, page_id FROM bitbag_cms_collection_pages_backup');
        $this->addSql('INSERT INTO bitbag_cms_section_blocks (section_id, block_id) SELECT collection_id, block_id FROM bitbag_cms_collection_blocks_backup');
        $this->addSql('INSERT INTO bitbag_cms_section_media (section_id, media_id) SELECT collection_id, media_id FROM bitbag_cms_collection_media_backup');
        $this->addSql('INSERT INTO bitbag_cms_page_sections (page_id, section_id) SELECT block_id, collection_id FROM bitbag_cms_page_collections_backup');
        $this->addSql('INSERT INTO bitbag_cms_block_sections (block_id, section_id) SELECT block_id, collection_id FROM bitbag_cms_block_collections_backup');
        $this->addSql('INSERT INTO bitbag_cms_media_sections (media_id, section_id) SELECT media_id, collection_id FROM bitbag_cms_media_collections_backup');

        // Drop the new tables
        $this->addSql('DROP TABLE bitbag_cms_block_collections');
        $this->addSql('DROP TABLE bitbag_cms_collection');
        $this->addSql('DROP TABLE bitbag_cms_collection_pages');
        $this->addSql('DROP TABLE bitbag_cms_collection_blocks');
        $this->addSql('DROP TABLE bitbag_cms_collection_media');
        $this->addSql('DROP TABLE bitbag_cms_collection_translation');
        $this->addSql('DROP TABLE bitbag_cms_media_collections');
        $this->addSql('DROP TABLE bitbag_cms_page_collections');

        // Drop the backup tables
        $this->addSql('DROP TABLE bitbag_cms_page_collections_backup');
        $this->addSql('DROP TABLE bitbag_cms_block_collections_backup');
        $this->addSql('DROP TABLE bitbag_cms_media_collections_backup');
        $this->addSql('DROP TABLE bitbag_cms_collection_translation_backup');
        $this->addSql('DROP TABLE bitbag_cms_collection_pages_backup');
        $this->addSql('DROP TABLE bitbag_cms_collection_blocks_backup');
        $this->addSql('DROP TABLE bitbag_cms_collection_media_backup');
        $this->addSql('DROP TABLE bitbag_cms_collection_backup');
    }
}
