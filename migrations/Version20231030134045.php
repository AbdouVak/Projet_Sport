<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030134045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_muscle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_topic (id INT AUTO_INCREMENT NOT NULL, categorie VARCHAR(50) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercice (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercice_categorie_muscle (exercice_id INT NOT NULL, categorie_muscle_id INT NOT NULL, INDEX IDX_819D5FE789D40298 (exercice_id), INDEX IDX_819D5FE79810D4B3 (categorie_muscle_id), PRIMARY KEY(exercice_id, categorie_muscle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, topic_id INT NOT NULL, user_id INT NOT NULL, date_creation DATETIME NOT NULL, contenue LONGTEXT NOT NULL, INDEX IDX_5A8A6C8D1F55203D (topic_id), INDEX IDX_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_DF7DFD0EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance_exercice (id INT AUTO_INCREMENT NOT NULL, exercice_id INT NOT NULL, seance_id INT DEFAULT NULL, serie INT DEFAULT NULL, poid INT DEFAULT NULL, repetition INT DEFAULT NULL, INDEX IDX_8A3473589D40298 (exercice_id), INDEX IDX_8A34735E3797A94 (seance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, categorie_topic_id INT NOT NULL, verrouiller TINYINT(1) NOT NULL, date_creation DATETIME NOT NULL, contenue LONGTEXT NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_9D40DE1BA76ED395 (user_id), INDEX IDX_9D40DE1B27D26157 (categorie_topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, pseudo VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercice_categorie_muscle ADD CONSTRAINT FK_819D5FE789D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercice_categorie_muscle ADD CONSTRAINT FK_819D5FE79810D4B3 FOREIGN KEY (categorie_muscle_id) REFERENCES categorie_muscle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE seance_exercice ADD CONSTRAINT FK_8A3473589D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
        $this->addSql('ALTER TABLE seance_exercice ADD CONSTRAINT FK_8A34735E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B27D26157 FOREIGN KEY (categorie_topic_id) REFERENCES categorie_topic (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice_categorie_muscle DROP FOREIGN KEY FK_819D5FE789D40298');
        $this->addSql('ALTER TABLE exercice_categorie_muscle DROP FOREIGN KEY FK_819D5FE79810D4B3');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D1F55203D');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EA76ED395');
        $this->addSql('ALTER TABLE seance_exercice DROP FOREIGN KEY FK_8A3473589D40298');
        $this->addSql('ALTER TABLE seance_exercice DROP FOREIGN KEY FK_8A34735E3797A94');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BA76ED395');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B27D26157');
        $this->addSql('DROP TABLE categorie_muscle');
        $this->addSql('DROP TABLE categorie_topic');
        $this->addSql('DROP TABLE exercice');
        $this->addSql('DROP TABLE exercice_categorie_muscle');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE seance_exercice');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
