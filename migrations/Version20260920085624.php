<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260920085624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banque (id INT AUTO_INCREMENT NOT NULL, nom_banque VARCHAR(255) NOT NULL, adresse_banque VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caf (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, annee VARCHAR(255) NOT NULL, mois VARCHAR(255) NOT NULL, montant_caf DOUBLE PRECISION DEFAULT NULL, INDEX IDX_6DE732E064D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charge (id INT AUTO_INCREMENT NOT NULL, lot_id INT DEFAULT NULL, annee VARCHAR(10) NOT NULL, mois VARCHAR(255) DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_556BA434A8CBA5F7 (lot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, banque_id INT DEFAULT NULL, lot_id INT DEFAULT NULL, debut_emprunt DATE DEFAULT NULL, INDEX IDX_364071D737E080D9 (banque_id), INDEX IDX_364071D7A8CBA5F7 (lot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, adresse_entreprise VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frais_gestion (id INT AUTO_INCREMENT NOT NULL, mandat_gestionnaire_id INT DEFAULT NULL, annee VARCHAR(255) NOT NULL, mois VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_D3FDAE9CB6198198 (mandat_gestionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gestionnaire (id INT AUTO_INCREMENT NOT NULL, nom_gestionnaire VARCHAR(255) NOT NULL, adresse_gestionnaire VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interet (id INT AUTO_INCREMENT NOT NULL, emprunt_id INT DEFAULT NULL, annee VARCHAR(255) NOT NULL, montant_interet DOUBLE PRECISION NOT NULL, INDEX IDX_A9816FA5AE7FEF94 (emprunt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locataire (id INT AUTO_INCREMENT NOT NULL, nom_locataire VARCHAR(255) NOT NULL, date_naissance DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, lot_id INT DEFAULT NULL, locataire_id INT DEFAULT NULL, debut_location DATE NOT NULL, fin_location DATE DEFAULT NULL, INDEX IDX_5E9E89CBA8CBA5F7 (lot_id), INDEX IDX_5E9E89CBD8A38199 (locataire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lot (id INT AUTO_INCREMENT NOT NULL, residence_id INT DEFAULT NULL, nom_lot VARCHAR(50) NOT NULL, date_achat DATETIME NOT NULL, date_vente DATETIME DEFAULT NULL, INDEX IDX_B81291B8B225FBD (residence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loyer (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, annee VARCHAR(255) NOT NULL, mois VARCHAR(255) NOT NULL, montant DOUBLE PRECISION DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, INDEX IDX_404562964D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mandat_gestionnaire (id INT AUTO_INCREMENT NOT NULL, lot_id INT DEFAULT NULL, gestionnaire_id INT DEFAULT NULL, debut_mandat DATE NOT NULL, fin_mandat DATE DEFAULT NULL, INDEX IDX_F8E84E1BA8CBA5F7 (lot_id), INDEX IDX_F8E84E1B6885AC1B (gestionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mandat_syndic (id INT AUTO_INCREMENT NOT NULL, residence_id INT DEFAULT NULL, syndic_id INT DEFAULT NULL, debut_mandat DATETIME DEFAULT NULL, fin_mandat DATETIME DEFAULT NULL, INDEX IDX_14BAA8338B225FBD (residence_id), INDEX IDX_14BAA833F0654A02 (syndic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prime_assurance (id INT AUTO_INCREMENT NOT NULL, lot_id INT DEFAULT NULL, annee VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, INDEX IDX_52E8C94CA8CBA5F7 (lot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recapitulatif (id INT AUTO_INCREMENT NOT NULL, residence_id INT DEFAULT NULL, annee VARCHAR(10) NOT NULL, total_recette DOUBLE PRECISION NOT NULL, frais_adm DOUBLE PRECISION NOT NULL, autres_frais DOUBLE PRECISION NOT NULL, primes_assurances DOUBLE PRECISION NOT NULL, travaux DOUBLE PRECISION NOT NULL, taxe_fonciere DOUBLE PRECISION NOT NULL, provision_pour_charge DOUBLE PRECISION NOT NULL, interet_emprunt DOUBLE PRECISION DEFAULT NULL, montant261 DOUBLE PRECISION DEFAULT NULL, montant229bis DOUBLE PRECISION DEFAULT NULL, montant230 DOUBLE PRECISION DEFAULT NULL, montant230bis DOUBLE PRECISION DEFAULT NULL, loyer DOUBLE PRECISION DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_72BFC5088B225FBD (residence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regularisation_ponctuelle (id INT AUTO_INCREMENT NOT NULL, residence_id INT DEFAULT NULL, annee VARCHAR(10) DEFAULT NULL, montant229bis DOUBLE PRECISION DEFAULT NULL, montant230 DOUBLE PRECISION DEFAULT NULL, montant230bis DOUBLE PRECISION DEFAULT NULL, INDEX IDX_D9DC29CD8B225FBD (residence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE residence (id INT AUTO_INCREMENT NOT NULL, nom_residence VARCHAR(50) NOT NULL, addresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE syndic (id INT AUTO_INCREMENT NOT NULL, nom_syndic VARCHAR(50) NOT NULL, adresse_syndic VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxe_fonciere (id INT AUTO_INCREMENT NOT NULL, residence_id INT DEFAULT NULL, annee VARCHAR(50) NOT NULL, montant INT NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, INDEX IDX_B7FF4BB48B225FBD (residence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travaux (id INT AUTO_INCREMENT NOT NULL, lot_id INT DEFAULT NULL, entreprise_id INT DEFAULT NULL, date_travaux DATE NOT NULL, type_travaux VARCHAR(255) DEFAULT NULL, montant_travaux DOUBLE PRECISION NOT NULL, annee VARCHAR(5) NOT NULL, INDEX IDX_6C24F39BA8CBA5F7 (lot_id), INDEX IDX_6C24F39BA4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caf ADD CONSTRAINT FK_6DE732E064D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA434A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D737E080D9 FOREIGN KEY (banque_id) REFERENCES banque (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE frais_gestion ADD CONSTRAINT FK_D3FDAE9CB6198198 FOREIGN KEY (mandat_gestionnaire_id) REFERENCES mandat_gestionnaire (id)');
        $this->addSql('ALTER TABLE interet ADD CONSTRAINT FK_A9816FA5AE7FEF94 FOREIGN KEY (emprunt_id) REFERENCES emprunt (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBA8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBD8A38199 FOREIGN KEY (locataire_id) REFERENCES locataire (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B8B225FBD FOREIGN KEY (residence_id) REFERENCES residence (id)');
        $this->addSql('ALTER TABLE loyer ADD CONSTRAINT FK_404562964D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE mandat_gestionnaire ADD CONSTRAINT FK_F8E84E1BA8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE mandat_gestionnaire ADD CONSTRAINT FK_F8E84E1B6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('ALTER TABLE mandat_syndic ADD CONSTRAINT FK_14BAA8338B225FBD FOREIGN KEY (residence_id) REFERENCES residence (id)');
        $this->addSql('ALTER TABLE mandat_syndic ADD CONSTRAINT FK_14BAA833F0654A02 FOREIGN KEY (syndic_id) REFERENCES syndic (id)');
        $this->addSql('ALTER TABLE prime_assurance ADD CONSTRAINT FK_52E8C94CA8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE recapitulatif ADD CONSTRAINT FK_72BFC5088B225FBD FOREIGN KEY (residence_id) REFERENCES residence (id)');
        $this->addSql('ALTER TABLE regularisation_ponctuelle ADD CONSTRAINT FK_D9DC29CD8B225FBD FOREIGN KEY (residence_id) REFERENCES residence (id)');
        $this->addSql('ALTER TABLE taxe_fonciere ADD CONSTRAINT FK_B7FF4BB48B225FBD FOREIGN KEY (residence_id) REFERENCES residence (id)');
        $this->addSql('ALTER TABLE travaux ADD CONSTRAINT FK_6C24F39BA8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE travaux ADD CONSTRAINT FK_6C24F39BA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caf DROP FOREIGN KEY FK_6DE732E064D218E');
        $this->addSql('ALTER TABLE charge DROP FOREIGN KEY FK_556BA434A8CBA5F7');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D737E080D9');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7A8CBA5F7');
        $this->addSql('ALTER TABLE frais_gestion DROP FOREIGN KEY FK_D3FDAE9CB6198198');
        $this->addSql('ALTER TABLE interet DROP FOREIGN KEY FK_A9816FA5AE7FEF94');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBA8CBA5F7');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBD8A38199');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B8B225FBD');
        $this->addSql('ALTER TABLE loyer DROP FOREIGN KEY FK_404562964D218E');
        $this->addSql('ALTER TABLE mandat_gestionnaire DROP FOREIGN KEY FK_F8E84E1BA8CBA5F7');
        $this->addSql('ALTER TABLE mandat_gestionnaire DROP FOREIGN KEY FK_F8E84E1B6885AC1B');
        $this->addSql('ALTER TABLE mandat_syndic DROP FOREIGN KEY FK_14BAA8338B225FBD');
        $this->addSql('ALTER TABLE mandat_syndic DROP FOREIGN KEY FK_14BAA833F0654A02');
        $this->addSql('ALTER TABLE prime_assurance DROP FOREIGN KEY FK_52E8C94CA8CBA5F7');
        $this->addSql('ALTER TABLE recapitulatif DROP FOREIGN KEY FK_72BFC5088B225FBD');
        $this->addSql('ALTER TABLE regularisation_ponctuelle DROP FOREIGN KEY FK_D9DC29CD8B225FBD');
        $this->addSql('ALTER TABLE taxe_fonciere DROP FOREIGN KEY FK_B7FF4BB48B225FBD');
        $this->addSql('ALTER TABLE travaux DROP FOREIGN KEY FK_6C24F39BA8CBA5F7');
        $this->addSql('ALTER TABLE travaux DROP FOREIGN KEY FK_6C24F39BA4AEAFEA');
        $this->addSql('DROP TABLE banque');
        $this->addSql('DROP TABLE caf');
        $this->addSql('DROP TABLE charge');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE frais_gestion');
        $this->addSql('DROP TABLE gestionnaire');
        $this->addSql('DROP TABLE interet');
        $this->addSql('DROP TABLE locataire');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE lot');
        $this->addSql('DROP TABLE loyer');
        $this->addSql('DROP TABLE mandat_gestionnaire');
        $this->addSql('DROP TABLE mandat_syndic');
        $this->addSql('DROP TABLE prime_assurance');
        $this->addSql('DROP TABLE recapitulatif');
        $this->addSql('DROP TABLE regularisation_ponctuelle');
        $this->addSql('DROP TABLE residence');
        $this->addSql('DROP TABLE syndic');
        $this->addSql('DROP TABLE taxe_fonciere');
        $this->addSql('DROP TABLE travaux');
    }
}
