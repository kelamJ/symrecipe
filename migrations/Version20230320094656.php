<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320094656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, plateforme VARCHAR(25) NOT NULL, societe VARCHAR(50) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, description LONGTEXT NOT NULL, is_favorite TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_tierlist (game_id INT NOT NULL, tierlist_id INT NOT NULL, INDEX IDX_46F5BC51E48FD905 (game_id), INDEX IDX_46F5BC5150CD24D4 (tierlist_id), PRIMARY KEY(game_id, tierlist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tierlist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(25) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_tierlist ADD CONSTRAINT FK_46F5BC51E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_tierlist ADD CONSTRAINT FK_46F5BC5150CD24D4 FOREIGN KEY (tierlist_id) REFERENCES tierlist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_tierlist DROP FOREIGN KEY FK_46F5BC51E48FD905');
        $this->addSql('ALTER TABLE game_tierlist DROP FOREIGN KEY FK_46F5BC5150CD24D4');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_tierlist');
        $this->addSql('DROP TABLE tierlist');
    }
}
