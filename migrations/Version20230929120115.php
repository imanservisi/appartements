<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929120115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE VIEW view_declaration AS SELECT nomResidence FROM Residence');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP VIEW view_declaration');

    }
}
