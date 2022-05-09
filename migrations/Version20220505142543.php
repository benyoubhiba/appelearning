<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505142543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, id_cours_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, INDEX IDX_8F91ABF02E149425 (id_cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, discription VARCHAR(255) NOT NULL, INDEX IDX_497DD634727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certificat (id INT AUTO_INCREMENT NOT NULL, libellé VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapitre (id INT AUTO_INCREMENT NOT NULL, id_cours_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_8C62B0252E149425 (id_cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, enseignant_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_8F87BF96E455FCC0 (enseignant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, id_forum_id INT DEFAULT NULL, id_certificat_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FDCA8C9C79175645 (id_forum_id), UNIQUE INDEX UNIQ_FDCA8C9C447D6BAA (id_certificat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours_classe (cours_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_E007AEFE7ECF78B0 (cours_id), INDEX IDX_E007AEFE8F5EA509 (classe_id), PRIMARY KEY(cours_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devoir (id INT AUTO_INCREMENT NOT NULL, id_lesson_id INT NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_749EA7714DCDBDB1 (id_lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, id_chapitre_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_F87474F37AC228C (id_chapitre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, prixtotal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF02E149425 FOREIGN KEY (id_cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634727ACA70 FOREIGN KEY (parent_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE chapitre ADD CONSTRAINT FK_8C62B0252E149425 FOREIGN KEY (id_cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C79175645 FOREIGN KEY (id_forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C447D6BAA FOREIGN KEY (id_certificat_id) REFERENCES certificat (id)');
        $this->addSql('ALTER TABLE cours_classe ADD CONSTRAINT FK_E007AEFE7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_classe ADD CONSTRAINT FK_E007AEFE8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devoir ADD CONSTRAINT FK_749EA7714DCDBDB1 FOREIGN KEY (id_lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F37AC228C FOREIGN KEY (id_chapitre_id) REFERENCES chapitre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634727ACA70');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C447D6BAA');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F37AC228C');
        $this->addSql('ALTER TABLE cours_classe DROP FOREIGN KEY FK_E007AEFE8F5EA509');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF02E149425');
        $this->addSql('ALTER TABLE chapitre DROP FOREIGN KEY FK_8C62B0252E149425');
        $this->addSql('ALTER TABLE cours_classe DROP FOREIGN KEY FK_E007AEFE7ECF78B0');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C79175645');
        $this->addSql('ALTER TABLE devoir DROP FOREIGN KEY FK_749EA7714DCDBDB1');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96E455FCC0');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE certificat');
        $this->addSql('DROP TABLE chapitre');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cours_classe');
        $this->addSql('DROP TABLE devoir');
        $this->addSql('DROP TABLE email');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
