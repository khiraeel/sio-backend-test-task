<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251007120937 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
         CREATE TYPE coupon_type AS ENUM ('fixed', 'percent');
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE coupon (
                id SERIAL NOT NULL,
                code VARCHAR(255) NOT NULL UNIQUE,
                name VARCHAR(255) NOT NULL,
                discount_type coupon_type NOT NULL,
                discount_percent_value NUMERIC(10, 2) NULL,
                discount_fixed_value_amount NUMERIC(10, 2) NULL,
                discount_fixed_value_currency VARCHAR(3) NULL,
                PRIMARY KEY(id)
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (
                id SERIAL NOT NULL,
                name VARCHAR(255) NOT NULL,
                price_value_amount NUMERIC(10, 2) NOT NULL,
                price_value_currency VARCHAR(3) NOT NULL,
                PRIMARY KEY(id)
            )
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DROP TABLE coupon
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
    }
}
