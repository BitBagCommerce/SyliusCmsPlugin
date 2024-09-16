<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240910113936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration removes teaser fields from the Page entity and adds them to the PageTranslation entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_cms_page DROP FOREIGN KEY FK_2C2740B2F56F16CF');
        $this->addSql('DROP INDEX IDX_2C2740B2F56F16CF ON sylius_cms_page');
        $this->addSql('ALTER TABLE sylius_cms_page DROP teaser_image_id, DROP teaser_title, DROP teaser_content');
        $this->addSql('ALTER TABLE sylius_cms_page_translation ADD teaser_image_id INT DEFAULT NULL, ADD teaser_title VARCHAR(255) DEFAULT NULL, ADD teaser_content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_cms_page_translation ADD CONSTRAINT FK_6D0D401BF56F16CF FOREIGN KEY (teaser_image_id) REFERENCES sylius_cms_media (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6D0D401BF56F16CF ON sylius_cms_page_translation (teaser_image_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_cms_page ADD teaser_image_id INT DEFAULT NULL, ADD teaser_title VARCHAR(255) DEFAULT NULL, ADD teaser_content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_cms_page ADD CONSTRAINT FK_2C2740B2F56F16CF FOREIGN KEY (teaser_image_id) REFERENCES sylius_cms_media (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_2C2740B2F56F16CF ON sylius_cms_page (teaser_image_id)');
        $this->addSql('ALTER TABLE sylius_cms_page_translation DROP FOREIGN KEY FK_6D0D401BF56F16CF');
        $this->addSql('DROP INDEX IDX_6D0D401BF56F16CF ON sylius_cms_page_translation');
        $this->addSql('ALTER TABLE sylius_cms_page_translation DROP teaser_image_id, DROP teaser_title, DROP teaser_content');
    }
}
