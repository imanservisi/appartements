<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260929125944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taxe_fonciere_ifi (id INT AUTO_INCREMENT NOT NULL, valeur INT NOT NULL, date DATE DEFAULT NULL, annee VARCHAR(4) DEFAULT NULL, nom_tfi VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valeur_declaree (id INT AUTO_INCREMENT NOT NULL, lot_id INT DEFAULT NULL, valeur INT DEFAULT NULL, annee VARCHAR(4) DEFAULT NULL, INDEX IDX_B80D323EA8CBA5F7 (lot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valeur_dette (id INT AUTO_INCREMENT NOT NULL, emprunt_id INT DEFAULT NULL, valeur INT NOT NULL, date DATE DEFAULT NULL, annee VARCHAR(4) DEFAULT NULL, INDEX IDX_DB715057AE7FEF94 (emprunt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE valeur_declaree ADD CONSTRAINT FK_B80D323EA8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE valeur_dette ADD CONSTRAINT FK_DB715057AE7FEF94 FOREIGN KEY (emprunt_id) REFERENCES emprunt (id)');
        $this->addSql('ALTER TABLE emprunt ADD nom_dette VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE lot ADD prix_acquisition INT DEFAULT NULL, ADD nb_pieces INT DEFAULT NULL, ADD superficie INT DEFAULT NULL, ADD bdi TINYINT(1) NOT NULL, ADD nom_societe VARCHAR(255) DEFAULT NULL, ADD adresse_societe VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE valeur_declaree DROP FOREIGN KEY FK_B80D323EA8CBA5F7');
        $this->addSql('ALTER TABLE valeur_dette DROP FOREIGN KEY FK_DB715057AE7FEF94');
        $this->addSql('DROP TABLE taxe_fonciere_ifi');
        $this->addSql('DROP TABLE valeur_declaree');
        $this->addSql('DROP TABLE valeur_dette');
        $this->addSql('ALTER TABLE emprunt DROP nom_dette');
        $this->addSql('ALTER TABLE lot DROP prix_acquisition, DROP nb_pieces, DROP superficie, DROP bdi, DROP nom_societe, DROP adresse_societe');
    }
}
