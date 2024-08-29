<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240703083513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration move name from media translation to media directly.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_media ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_media_translation DROP name');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_media DROP name');
        $this->addSql('ALTER TABLE bitbag_cms_media_translation ADD name VARCHAR(255) DEFAULT NULL');
    }
}
