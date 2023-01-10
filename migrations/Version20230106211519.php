<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230106211519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables for REST API task';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE product (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, price INTEGER NOT NULL, currency VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE product');
    }
}
