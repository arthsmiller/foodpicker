<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220909160433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE commiters_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE orders_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE restaurants_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE commiters (id VARCHAR(255) NOT NULL, user_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, user_profile_picture_url VARCHAR(255) NOT NULL, banned BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE orders (id VARCHAR(255) NOT NULL, restaurant_id VARCHAR(255) DEFAULT NULL, commiter_id VARCHAR(255) DEFAULT NULL, order_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, delivery_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, total_persons INT NOT NULL, total_price INT NOT NULL, total_items INT NOT NULL, faulty BOOLEAN NOT NULL, bonus BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E52FFDEEB1E7706E ON orders (restaurant_id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEEE3E60758 ON orders (commiter_id)');
        $this->addSql('CREATE TABLE restaurants (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, categories JSON DEFAULT NULL, shop_url VARCHAR(255) NOT NULL, logo_file VARCHAR(255) NOT NULL, logo_url VARCHAR(255) NOT NULL, background_file VARCHAR(255) NOT NULL, background_url VARCHAR(255) NOT NULL, score INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(6) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEE3E60758 FOREIGN KEY (commiter_id) REFERENCES commiters (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE commiters_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE orders_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE restaurants_id_seq CASCADE');
        $this->addSql('ALTER TABLE orders DROP CONSTRAINT FK_E52FFDEEB1E7706E');
        $this->addSql('ALTER TABLE orders DROP CONSTRAINT FK_E52FFDEEE3E60758');
        $this->addSql('DROP TABLE commiters');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE restaurants');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
