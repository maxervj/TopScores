<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250506134650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE jeu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE partie (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, partie_id INT DEFAULT NULL, date DATE NOT NULL, score VARCHAR(255) NOT NULL, INDEX IDX_59B1F3DA76ED395 (user_id), INDEX IDX_59B1F3DE075F7A4 (partie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partie ADD CONSTRAINT FK_59B1F3DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partie ADD CONSTRAINT FK_59B1F3DE075F7A4 FOREIGN KEY (partie_id) REFERENCES jeu (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3DA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3DE075F7A4
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE jeu
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE partie
        SQL);
    }
}
