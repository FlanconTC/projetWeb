<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104144113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dev (id INT NOT NULL, favoris_dev_id INT DEFAULT NULL, langages_de_prog VARCHAR(255) DEFAULT NULL, niveau_experience INT DEFAULT NULL, salaire_min INT DEFAULT NULL, biographie LONGTEXT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, nb_vues INT DEFAULT NULL, INDEX IDX_1173F1059E47C30D (favoris_dev_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT NOT NULL, fiche_de_poste_id INT DEFAULT NULL, INDEX IDX_D19FA60F76AAB91 (fiche_de_poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_de_poste (id INT AUTO_INCREMENT NOT NULL, dev_id INT DEFAULT NULL, titre_poste VARCHAR(255) DEFAULT NULL, technologies_recherchees VARCHAR(255) DEFAULT NULL, niveau_exp_requis INT DEFAULT NULL, nb_vues INT DEFAULT NULL, salaire_propose INT DEFAULT NULL, description_detaillee LONGTEXT DEFAULT NULL, INDEX IDX_C9606A6FA421F7B0 (dev_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, recherche VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matching (id INT AUTO_INCREMENT NOT NULL, dev_id INT DEFAULT NULL, entreprise_id INT DEFAULT NULL, like_from_dev INT DEFAULT NULL, like_from_e INT DEFAULT NULL, INDEX IDX_DC10F289A421F7B0 (dev_id), INDEX IDX_DC10F289A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messagerie (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, dev_id INT DEFAULT NULL, message LONGTEXT DEFAULT NULL, date_creation DATETIME DEFAULT NULL, lu_dev TINYINT(1) DEFAULT NULL, lu_e TINYINT(1) DEFAULT NULL, INDEX IDX_14E8F60CA4AEAFEA (entreprise_id), INDEX IDX_14E8F60CA421F7B0 (dev_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, dev_evaluateur_id INT DEFAULT NULL, dev_evalue_id INT DEFAULT NULL, note INT DEFAULT NULL, INDEX IDX_CFBDFA14D2661763 (dev_evaluateur_id), INDEX IDX_CFBDFA14A5B10807 (dev_evalue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, historique_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, profile VARCHAR(255) DEFAULT NULL, localisation VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_1D1C63B36128735E (historique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dev ADD CONSTRAINT FK_1173F1059E47C30D FOREIGN KEY (favoris_dev_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE dev ADD CONSTRAINT FK_1173F105BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA60F76AAB91 FOREIGN KEY (fiche_de_poste_id) REFERENCES fiche_de_poste (id)');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA60BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiche_de_poste ADD CONSTRAINT FK_C9606A6FA421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id)');
        $this->addSql('ALTER TABLE matching ADD CONSTRAINT FK_DC10F289A421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id)');
        $this->addSql('ALTER TABLE matching ADD CONSTRAINT FK_DC10F289A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE messagerie ADD CONSTRAINT FK_14E8F60CA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE messagerie ADD CONSTRAINT FK_14E8F60CA421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14D2661763 FOREIGN KEY (dev_evaluateur_id) REFERENCES dev (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A5B10807 FOREIGN KEY (dev_evalue_id) REFERENCES dev (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B36128735E FOREIGN KEY (historique_id) REFERENCES historique (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dev DROP FOREIGN KEY FK_1173F1059E47C30D');
        $this->addSql('ALTER TABLE dev DROP FOREIGN KEY FK_1173F105BF396750');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA60F76AAB91');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA60BF396750');
        $this->addSql('ALTER TABLE fiche_de_poste DROP FOREIGN KEY FK_C9606A6FA421F7B0');
        $this->addSql('ALTER TABLE matching DROP FOREIGN KEY FK_DC10F289A421F7B0');
        $this->addSql('ALTER TABLE matching DROP FOREIGN KEY FK_DC10F289A4AEAFEA');
        $this->addSql('ALTER TABLE messagerie DROP FOREIGN KEY FK_14E8F60CA4AEAFEA');
        $this->addSql('ALTER TABLE messagerie DROP FOREIGN KEY FK_14E8F60CA421F7B0');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14D2661763');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A5B10807');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B36128735E');
        $this->addSql('DROP TABLE dev');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE fiche_de_poste');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE matching');
        $this->addSql('DROP TABLE messagerie');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE utilisateur');
    }
}
