<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105144819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developer_profile (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, location VARCHAR(255) DEFAULT NULL, programming_languages JSON DEFAULT NULL, experience_level INT DEFAULT NULL, minimun_salary INT DEFAULT NULL, biography LONGTEXT DEFAULT NULL, avatar LONGBLOB DEFAULT NULL, UNIQUE INDEX UNIQ_EFC94CA4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, favorite_developer_id INT DEFAULT NULL, favorite_job_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E46960F5A76ED395 (user_id), INDEX IDX_E46960F58BCB9008 (favorite_developer_id), INDEX IDX_E46960F537552253 (favorite_job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_post (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, title VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, required_technologies JSON DEFAULT NULL, required_experience INT DEFAULT NULL, offered_salary INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DD461ACC979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matching (id INT AUTO_INCREMENT NOT NULL, developer_id INT NOT NULL, job_post_id INT NOT NULL, match_score INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DC10F28964DD9267 (developer_id), INDEX IDX_DC10F289D166B4B7 (job_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE developer_profile ADD CONSTRAINT FK_EFC94CA4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F58BCB9008 FOREIGN KEY (favorite_developer_id) REFERENCES developer_profile (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F537552253 FOREIGN KEY (favorite_job_id) REFERENCES job_post (id)');
        $this->addSql('ALTER TABLE job_post ADD CONSTRAINT FK_DD461ACC979B1AD6 FOREIGN KEY (company_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matching ADD CONSTRAINT FK_DC10F28964DD9267 FOREIGN KEY (developer_id) REFERENCES developer_profile (id)');
        $this->addSql('ALTER TABLE matching ADD CONSTRAINT FK_DC10F289D166B4B7 FOREIGN KEY (job_post_id) REFERENCES job_post (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developer_profile DROP FOREIGN KEY FK_EFC94CA4A76ED395');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5A76ED395');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F58BCB9008');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F537552253');
        $this->addSql('ALTER TABLE job_post DROP FOREIGN KEY FK_DD461ACC979B1AD6');
        $this->addSql('ALTER TABLE matching DROP FOREIGN KEY FK_DC10F28964DD9267');
        $this->addSql('ALTER TABLE matching DROP FOREIGN KEY FK_DC10F289D166B4B7');
        $this->addSql('DROP TABLE developer_profile');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE job_post');
        $this->addSql('DROP TABLE matching');
        $this->addSql('DROP TABLE user');
    }
}
