<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240705220819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auteur ADD name VARCHAR(255) NOT NULL, ADD date_of_birth DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD date_of_death DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD nationality VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auteur DROP name, DROP date_of_birth, DROP date_of_death, DROP nationality');
    }
}
