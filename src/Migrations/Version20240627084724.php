<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627084724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_cms_content_configuration (id INT AUTO_INCREMENT NOT NULL, block_id INT DEFAULT NULL, page_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, configuration JSON NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_D899EFA7E9ED820C (block_id), INDEX IDX_D899EFA7C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_cms_page_locales (page_id INT NOT NULL, locale_id INT NOT NULL, INDEX IDX_EF20FD23C4663E4 (page_id), INDEX IDX_EF20FD23E559DFD1 (locale_id), PRIMARY KEY(page_id, locale_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration ADD CONSTRAINT FK_D899EFA7E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id)');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration ADD CONSTRAINT FK_D899EFA7C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id)');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales ADD CONSTRAINT FK_EF20FD23C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales ADD CONSTRAINT FK_EF20FD23E559DFD1 FOREIGN KEY (locale_id) REFERENCES sylius_locale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_block_content DROP FOREIGN KEY FK_FAA763A8E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_page_products DROP FOREIGN KEY FK_4D64FA854584665A');
        $this->addSql('ALTER TABLE bitbag_cms_page_products DROP FOREIGN KEY FK_4D64FA85C4663E4');
        $this->addSql('DROP TABLE bitbag_cms_block_content');
        $this->addSql('DROP TABLE bitbag_cms_page_products');
        $this->addSql('ALTER TABLE bitbag_cms_page ADD name VARCHAR(255) DEFAULT NULL, ADD meta_keywords VARCHAR(1000) DEFAULT NULL, ADD meta_description VARCHAR(5000) DEFAULT NULL, ADD title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation DROP FOREIGN KEY FK_FDD074A63DA5256D');
        $this->addSql('DROP INDEX IDX_FDD074A63DA5256D ON bitbag_cms_page_translation');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation DROP image_id, DROP name, DROP breadcrumb, DROP name_when_linked, DROP description_when_linked, DROP meta_keywords, DROP meta_description, DROP content, DROP title');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bitbag_cms_block_content (id INT AUTO_INCREMENT NOT NULL, block_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, configuration JSON NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_FAA763A8E9ED820C (block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bitbag_cms_page_products (page_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_4D64FA854584665A (product_id), INDEX IDX_4D64FA85C4663E4 (page_id), PRIMARY KEY(page_id, product_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_block_content ADD CONSTRAINT FK_FAA763A8E9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_block (id)');
        $this->addSql('ALTER TABLE bitbag_cms_page_products ADD CONSTRAINT FK_4D64FA854584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_page_products ADD CONSTRAINT FK_4D64FA85C4663E4 FOREIGN KEY (page_id) REFERENCES bitbag_cms_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration DROP FOREIGN KEY FK_D899EFA7E9ED820C');
        $this->addSql('ALTER TABLE bitbag_cms_content_configuration DROP FOREIGN KEY FK_D899EFA7C4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales DROP FOREIGN KEY FK_EF20FD23C4663E4');
        $this->addSql('ALTER TABLE bitbag_cms_page_locales DROP FOREIGN KEY FK_EF20FD23E559DFD1');
        $this->addSql('DROP TABLE bitbag_cms_content_configuration');
        $this->addSql('DROP TABLE bitbag_cms_page_locales');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation ADD image_id INT DEFAULT NULL, ADD name VARCHAR(255) DEFAULT NULL, ADD breadcrumb VARCHAR(255) DEFAULT NULL, ADD name_when_linked VARCHAR(255) DEFAULT NULL, ADD description_when_linked VARCHAR(1000) DEFAULT NULL, ADD meta_keywords VARCHAR(1000) DEFAULT NULL, ADD meta_description VARCHAR(5000) DEFAULT NULL, ADD content LONGTEXT DEFAULT NULL, ADD title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_page_translation ADD CONSTRAINT FK_FDD074A63DA5256D FOREIGN KEY (image_id) REFERENCES bitbag_cms_media (id)');
        $this->addSql('CREATE INDEX IDX_FDD074A63DA5256D ON bitbag_cms_page_translation (image_id)');
        $this->addSql('ALTER TABLE bitbag_cms_page DROP name, DROP meta_keywords, DROP meta_description, DROP title');
    }
}
