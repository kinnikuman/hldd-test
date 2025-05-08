<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250507180837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates Vending machine tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE vending_machine_items (
                name VARCHAR(50) PRIMARY KEY NOT NULL,
                price_in_cents INT NOT NULL,
                count INT NOT NULL
            )
        ');

        $this->addSql('
            CREATE TABLE vending_machine_coins (
                coin_in_cents INT PRIMARY KEY,
                number_of_coins INT NOT NULL
            )
        ');

        $this->addSql('
            CREATE TABLE user_coins (
                id VARCHAR(36) NOT NULL PRIMARY KEY,
                coin_in_cents INT
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE vending_machine_items');
        $this->addSql('DROP TABLE vending_machine_coins');
        $this->addSql('DROP TABLE user_coins');
    }
}
