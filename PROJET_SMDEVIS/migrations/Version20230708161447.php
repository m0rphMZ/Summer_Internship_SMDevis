<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230708161447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY fk_demid');
        $this->addSql('CREATE TABLE propositions (ref_proposition INT AUTO_INCREMENT NOT NULL, ref_proj INT DEFAULT NULL, proprietaire_proposition VARCHAR(255) NOT NULL, description_proposition VARCHAR(250) NOT NULL, INDEX fk_ref_proj (ref_proj), PRIMARY KEY(ref_proposition)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (user_id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, login_code INT DEFAULT NULL, nom VARCHAR(200) NOT NULL, prenom VARCHAR(200) NOT NULL, civilite VARCHAR(200) NOT NULL, email VARCHAR(200) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(200) NOT NULL, ville VARCHAR(200) NOT NULL, codepostal INT NOT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE propositions ADD CONSTRAINT FK_E9AB0286457F7D17 FOREIGN KEY (ref_proj) REFERENCES projects (ref_proj)');
        $this->addSql('DROP TABLE demandeurs');
        $this->addSql('DROP TABLE partners');
        $this->addSql('DROP INDEX fk_demid ON projects');
        $this->addSql('ALTER TABLE projects ADD user_id INT DEFAULT NULL, DROP dem_id, DROP situation');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4A76ED395 FOREIGN KEY (user_id) REFERENCES users (user_id)');
        $this->addSql('CREATE INDEX fk_user_id ON projects (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4A76ED395');
        $this->addSql('CREATE TABLE demandeurs (dem_id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, civilite VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, telephone INT NOT NULL, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, codepostale INT NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(dem_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE partners (part_id INT AUTO_INCREMENT NOT NULL, etat VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, login_code INT DEFAULT NULL, nom VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_soc VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, civilite VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, telephone INT NOT NULL, adresse VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, ville VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, codepostal INT NOT NULL, PRIMARY KEY(part_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE propositions DROP FOREIGN KEY FK_E9AB0286457F7D17');
        $this->addSql('DROP TABLE propositions');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP INDEX fk_user_id ON projects');
        $this->addSql('ALTER TABLE projects ADD dem_id INT NOT NULL, ADD situation VARCHAR(255) NOT NULL, DROP user_id');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT fk_demid FOREIGN KEY (dem_id) REFERENCES demandeurs (dem_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_demid ON projects (dem_id)');
    }
}
