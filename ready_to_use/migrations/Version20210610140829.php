<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610140829 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, foundation_date DATE DEFAULT NULL, location VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, battery INT DEFAULT NULL, camera VARCHAR(30) DEFAULT NULL, graphic_card VARCHAR(30) DEFAULT NULL, hard_disk VARCHAR(30) DEFAULT NULL, os_version VARCHAR(30) DEFAULT NULL, processor VARCHAR(30) DEFAULT NULL, ram INT DEFAULT NULL, screen_size VARCHAR(30) DEFAULT NULL, tactile TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, category_id INT DEFAULT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, release_date DATE DEFAULT NULL, show_battery_field TINYINT(1) NOT NULL, show_camera_field TINYINT(1) NOT NULL, show_graphic_card_field TINYINT(1) NOT NULL, show_hard_disk_field TINYINT(1) NOT NULL, show_os_version_field TINYINT(1) NOT NULL, show_processor_field TINYINT(1) NOT NULL, show_ram_field TINYINT(1) NOT NULL, show_screen_field TINYINT(1) NOT NULL, show_tactile_field TINYINT(1) NOT NULL, INDEX IDX_D79572D944F5D008 (brand_id), INDEX IDX_D79572D912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, model_id INT NOT NULL, product_condition INT NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_29D6873E7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, ordered_by_id INT DEFAULT NULL, status INT NOT NULL, request_date DATETIME NOT NULL, paid_date DATETIME DEFAULT NULL, cancel_date DATETIME DEFAULT NULL, INDEX IDX_F529939891FF3C4D (ordered_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, order_ref_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_52EA1F094584665A (product_id), INDEX IDX_52EA1F09E238517C (order_ref_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, extension INT NOT NULL, size INT NOT NULL, name VARCHAR(40) NOT NULL, INDEX IDX_16DB4F894584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, wharehouse_id INT DEFAULT NULL, model_id INT DEFAULT NULL, feature_id INT DEFAULT NULL, description VARCHAR(200) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, deposit_date DATETIME NOT NULL, product_condition INT NOT NULL, INDEX IDX_D34A04AD9D2A6462 (wharehouse_id), INDEX IDX_D34A04AD7975B7E7 (model_id), INDEX IDX_D34A04AD60E4B879 (feature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sell (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, sold_by_id INT NOT NULL, status INT NOT NULL, deposit_date DATETIME NOT NULL, accepted_date DATETIME DEFAULT NULL, counter_offer DOUBLE PRECISION DEFAULT NULL, voucher VARCHAR(12) DEFAULT NULL, UNIQUE INDEX UNIQ_9B9ED07D4584665A (product_id), INDEX IDX_9B9ED07D148EA8A1 (sold_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, signup_date DATETIME NOT NULL, iban VARCHAR(50) DEFAULT NULL, address VARCHAR(50) DEFAULT NULL, roles INT NOT NULL, stripe_customer_id VARCHAR(18) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_verification (id INT AUTO_INCREMENT NOT NULL, requesting_user_id INT NOT NULL, verified_by_id INT DEFAULT NULL, status INT NOT NULL, request_date DATETIME NOT NULL, validation_date DATETIME DEFAULT NULL, INDEX IDX_DA3DB9092A841BBC (requesting_user_id), INDEX IDX_DA3DB90969F4B775 (verified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wharehouse (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(50) NOT NULL, city VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939891FF3C4D FOREIGN KEY (ordered_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09E238517C FOREIGN KEY (order_ref_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F894584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9D2A6462 FOREIGN KEY (wharehouse_id) REFERENCES wharehouse (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD60E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id)');
        $this->addSql('ALTER TABLE sell ADD CONSTRAINT FK_9B9ED07D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE sell ADD CONSTRAINT FK_9B9ED07D148EA8A1 FOREIGN KEY (sold_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_verification ADD CONSTRAINT FK_DA3DB9092A841BBC FOREIGN KEY (requesting_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_verification ADD CONSTRAINT FK_DA3DB90969F4B775 FOREIGN KEY (verified_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D912469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD60E4B879');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E7975B7E7');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7975B7E7');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09E238517C');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094584665A');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F894584665A');
        $this->addSql('ALTER TABLE sell DROP FOREIGN KEY FK_9B9ED07D4584665A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939891FF3C4D');
        $this->addSql('ALTER TABLE sell DROP FOREIGN KEY FK_9B9ED07D148EA8A1');
        $this->addSql('ALTER TABLE user_verification DROP FOREIGN KEY FK_DA3DB9092A841BBC');
        $this->addSql('ALTER TABLE user_verification DROP FOREIGN KEY FK_DA3DB90969F4B775');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD9D2A6462');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE sell');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_verification');
        $this->addSql('DROP TABLE wharehouse');
    }
}
