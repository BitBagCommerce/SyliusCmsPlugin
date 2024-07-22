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

final class Version20240715083336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration renames block_id to media_id in bitbag_cms_media_channels table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_media_channels DROP FOREIGN KEY FK_D109622EE9ED820C');
        $this->addSql('DROP INDEX IDX_D109622EE9ED820C ON bitbag_cms_media_channels');
        $this->addSql('DROP INDEX `primary` ON bitbag_cms_media_channels');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels CHANGE block_id media_id INT NOT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels ADD CONSTRAINT FK_D109622EEA9FDD75 FOREIGN KEY (media_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D109622EEA9FDD75 ON bitbag_cms_media_channels (media_id)');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels ADD PRIMARY KEY (media_id, channel_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE bitbag_cms_media_channels DROP FOREIGN KEY FK_D109622EEA9FDD75');
        $this->addSql('DROP INDEX IDX_D109622EEA9FDD75 ON bitbag_cms_media_channels');
        $this->addSql('DROP INDEX `PRIMARY` ON bitbag_cms_media_channels');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels CHANGE media_id block_id INT NOT NULL');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels ADD CONSTRAINT FK_D109622EE9ED820C FOREIGN KEY (block_id) REFERENCES bitbag_cms_media (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D109622EE9ED820C ON bitbag_cms_media_channels (block_id)');
        $this->addSql('ALTER TABLE bitbag_cms_media_channels ADD PRIMARY KEY (block_id, channel_id)');
    }
}
