<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221219070632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details ADD address_1 VARCHAR(255) NOT NULL, ADD address_2 VARCHAR(255) NOT NULL, ADD address_3 VARCHAR(255) NOT NULL, ADD address_4 VARCHAR(255) NOT NULL, ADD zipcode INT NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL, CHANGE total total INT DEFAULT NULL, CHANGE status status INT NOT NULL');
        $this->addSql('ALTER TABLE order_items DROP created_at, DROP updated_at, CHANGE order_id order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE warranty warranty DATE DEFAULT NULL, CHANGE gift gift LONGTEXT DEFAULT NULL, CHANGE model model VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE gender zipcode INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details DROP address_1, DROP address_2, DROP address_3, DROP address_4, DROP zipcode, DROP firstname, DROP lastname, DROP email, DROP phone, CHANGE total total NUMERIC(10, 0) DEFAULT NULL, CHANGE status status INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_items ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, CHANGE order_id order_id INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE warranty warranty VARCHAR(255) NOT NULL, CHANGE gift gift LONGTEXT NOT NULL, CHANGE model model VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE zipcode gender INT DEFAULT NULL');
    }
}
