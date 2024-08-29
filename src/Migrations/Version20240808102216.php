<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240808102216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration adds teaser image, title and content to the Page entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_page ADD teaser_image_id INT DEFAULT NULL, ADD teaser_title VARCHAR(255) DEFAULT NULL, ADD teaser_content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_page ADD CONSTRAINT FK_18F07F1BF56F16CF FOREIGN KEY (teaser_image_id) REFERENCES bitbag_cms_media (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_18F07F1BF56F16CF ON bitbag_cms_page (teaser_image_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_page DROP FOREIGN KEY FK_18F07F1BF56F16CF');
        $this->addSql('DROP INDEX IDX_18F07F1BF56F16CF ON bitbag_cms_page');
        $this->addSql('ALTER TABLE bitbag_cms_page DROP teaser_image_id, DROP teaser_title, DROP teaser_content');
    }
}
