<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607221919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coupons (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT DEFAULT NULL, receive_date DATETIME DEFAULT NULL, expiration_date DATETIME DEFAULT NULL, amount INT NOT NULL, redeemed TINYINT(1) DEFAULT 0, INDEX IDX_F5641118B1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT DEFAULT NULL, commiter_id INT DEFAULT NULL, order_time DATETIME DEFAULT NULL, delivery_time DATETIME DEFAULT NULL, total_price INT NOT NULL, total_items INT NOT NULL, faulty TINYINT(1) NOT NULL, bonus TINYINT(1) NOT NULL, driver_needed_help TINYINT(1) NOT NULL, score INT DEFAULT 0 NOT NULL, INDEX IDX_E52FFDEEB1E7706E (restaurant_id), INDEX IDX_E52FFDEEE3E60758 (commiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurants (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, categories JSON DEFAULT NULL, shop_url VARCHAR(255) NOT NULL, logo_file VARCHAR(255) NOT NULL, logo_url VARCHAR(255) NOT NULL, background_file VARCHAR(255) DEFAULT NULL, background_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, user_profile_picture_url VARCHAR(255) NOT NULL, banned TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coupons ADD CONSTRAINT FK_F5641118B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEE3E60758 FOREIGN KEY (commiter_id) REFERENCES `users` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coupons DROP FOREIGN KEY FK_F5641118B1E7706E');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEB1E7706E');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEE3E60758');
        $this->addSql('DROP TABLE coupons');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE restaurants');
        $this->addSql('DROP TABLE `users`');
    }
}
