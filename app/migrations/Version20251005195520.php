<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251005195520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE coupon (
                code VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                discount_type VARCHAR(255) NOT NULL,
                discount_value NUMERIC(10, 2) NOT NULL,
                PRIMARY KEY(code)
            )
        SQL);

        $this->addSql(<<<'SQL'
            CREATE TABLE product (
                id SERIAL NOT NULL,
                name VARCHAR(255) NOT NULL,
                price NUMERIC(10, 2) NOT NULL,
                PRIMARY KEY(id)
             )
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE coupon
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
    }
}
