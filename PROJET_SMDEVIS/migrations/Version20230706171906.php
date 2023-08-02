<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706171906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY fk_user_id');
        $this->addSql('ALTER TABLE projects CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4A76ED395 FOREIGN KEY (user_id) REFERENCES users (user_id)');
        $this->addSql('ALTER TABLE propositions DROP FOREIGN KEY fk_ref_proj');
        $this->addSql('ALTER TABLE propositions CHANGE ref_proj ref_proj INT DEFAULT NULL');
        $this->addSql('ALTER TABLE propositions ADD CONSTRAINT FK_E9AB0286457F7D17 FOREIGN KEY (ref_proj) REFERENCES projects (ref_proj)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4A76ED395');
        $this->addSql('ALTER TABLE projects CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE propositions DROP FOREIGN KEY FK_E9AB0286457F7D17');
        $this->addSql('ALTER TABLE propositions CHANGE ref_proj ref_proj INT NOT NULL');
        $this->addSql('ALTER TABLE propositions ADD CONSTRAINT fk_ref_proj FOREIGN KEY (ref_proj) REFERENCES projects (ref_proj) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
