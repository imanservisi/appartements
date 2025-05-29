<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529145301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE regularisation_ponctuelle (id INT AUTO_INCREMENT NOT NULL, residence_id INT DEFAULT NULL, annee VARCHAR(10) DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_D9DC29CD8B225FBD (residence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE regularisation_ponctuelle ADD CONSTRAINT FK_D9DC29CD8B225FBD FOREIGN KEY (residence_id) REFERENCES residence (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE regularisation_ponctuelle DROP FOREIGN KEY FK_D9DC29CD8B225FBD');
        $this->addSql('DROP TABLE regularisation_ponctuelle');
    }
}
