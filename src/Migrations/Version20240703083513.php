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

final class Version20240703083513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration removes media products and move name from media translation to media directly.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_media_products DROP FOREIGN KEY FK_91A7DAC24584665A');
        $this->addSql('ALTER TABLE bitbag_cms_media_products DROP FOREIGN KEY FK_91A7DAC2EA9FDD75');
        $this->addSql('DROP TABLE bitbag_cms_media_products');
        $this->addSql('ALTER TABLE bitbag_cms_media ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_media_translation DROP name');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitbag_cms_media_products (media_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_91A7DAC24584665A (product_id), INDEX IDX_91A7DAC2EA9FDD75 (media_id), PRIMARY KEY(media_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitbag_cms_media_products ADD CONSTRAINT FK_91A7DAC24584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media_products ADD CONSTRAINT FK_91A7DAC2EA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitbag_cms_media DROP name');
        $this->addSql('ALTER TABLE bitbag_cms_media_translation ADD name VARCHAR(255) DEFAULT NULL');
    }
}
