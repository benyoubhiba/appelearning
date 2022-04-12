<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412142655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aprennant (id INT AUTO_INCREMENT NOT NULL, panier_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3A775435F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aprennant_classe (aprennant_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_CF94BC1B54579EBE (aprennant_id), INDEX IDX_CF94BC1B8F5EA509 (classe_id), PRIMARY KEY(aprennant_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, enseignant_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_8F87BF96E455FCC0 (enseignant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, prixtotal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aprennant ADD CONSTRAINT FK_3A775435F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE aprennant_classe ADD CONSTRAINT FK_CF94BC1B54579EBE FOREIGN KEY (aprennant_id) REFERENCES aprennant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aprennant_classe ADD CONSTRAINT FK_CF94BC1B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aprennant_classe DROP FOREIGN KEY FK_CF94BC1B54579EBE');
        $this->addSql('ALTER TABLE aprennant_classe DROP FOREIGN KEY FK_CF94BC1B8F5EA509');
        $this->addSql('ALTER TABLE aprennant DROP FOREIGN KEY FK_3A775435F77D927C');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96E455FCC0');
        $this->addSql('DROP TABLE aprennant');
        $this->addSql('DROP TABLE aprennant_classe');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
