<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230102165111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE user (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL
              , email VARCHAR(180) NOT NULL
              , roles CLOB NOT NULL --(DC2Type:json)
              , password VARCHAR(255) NOT NULL
            )
            SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_channels (
                user_id INTEGER NOT NULL
              , config CLOB NOT NULL --(DC2Type:json)
              , PRIMARY KEY(user_id)
              , CONSTRAINT FK_139906B6A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            )
            SQL);
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user_channels');
        $this->addSql('DROP TABLE user');
    }
}
