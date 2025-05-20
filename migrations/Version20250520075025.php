<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520075025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3DE075F7A4
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_59B1F3DE075F7A4 ON partie
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partie ADD pseudo VARCHAR(255) NOT NULL, CHANGE partie_id jeu_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partie ADD CONSTRAINT FK_59B1F3D8C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_59B1F3D8C9E392E ON partie (jeu_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3D8C9E392E
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_59B1F3D8C9E392E ON partie
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partie DROP pseudo, CHANGE jeu_id partie_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partie ADD CONSTRAINT FK_59B1F3DE075F7A4 FOREIGN KEY (partie_id) REFERENCES jeu (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_59B1F3DE075F7A4 ON partie (partie_id)
        SQL);
    }
}
