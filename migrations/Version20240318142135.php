<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318142135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE currency_rate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bank_name VARCHAR(255) NOT NULL, currency VARCHAR(255) NOT NULL, currency_base VARCHAR(255) NOT NULL, rate_sell VARCHAR(255) NOT NULL, rate_buy VARCHAR(255) NOT NULL, created DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX idx_currency_rate ON currency_rate (bank_name, currency_base, currency)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_currency_rate ON currency_rate');
        $this->addSql('DROP TABLE currency_rate');
    }
}
