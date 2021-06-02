<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411174049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, battery VARCHAR(50) DEFAULT NULL, camera VARCHAR(50) DEFAULT NULL, graphic_card VARCHAR(50) DEFAULT NULL, hard_disk VARCHAR(50) DEFAULT NULL, os_version VARCHAR(50) DEFAULT NULL, processor VARCHAR(50) DEFAULT NULL, ram VARCHAR(50) DEFAULT NULL, screen_size VARCHAR(50) DEFAULT NULL, tactile VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_1FD775664584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, extension INT NOT NULL, size INT NOT NULL, INDEX IDX_16DB4F894584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, wharehouse_id INT NOT NULL, brand VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, description VARCHAR(200) DEFAULT NULL, product_condition INT NOT NULL, price DOUBLE PRECISION NOT NULL, deposit_date DATETIME NOT NULL, INDEX IDX_D34A04AD9D2A6462 (wharehouse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, purchased_by_id INT NOT NULL, status INT NOT NULL, coins_earned INT NOT NULL, payment_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_6117D13B4584665A (product_id), INDEX IDX_6117D13B51D43F65 (purchased_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sell (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, sold_by_id INT NOT NULL, status INT NOT NULL, deposit_date DATETIME NOT NULL, accepted_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_9B9ED07D4584665A (product_id), INDEX IDX_9B9ED07D148EA8A1 (sold_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, signup_date DATETIME NOT NULL, iban VARCHAR(50) DEFAULT NULL, address VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_verification (id INT AUTO_INCREMENT NOT NULL, requesting_user_id INT NOT NULL, verified_by_id INT NOT NULL, status INT NOT NULL, request_date DATETIME NOT NULL, validation_date DATETIME DEFAULT NULL, INDEX IDX_DA3DB9092A841BBC (requesting_user_id), INDEX IDX_DA3DB90969F4B775 (verified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wharehouse (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feature ADD CONSTRAINT FK_1FD775664584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F894584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9D2A6462 FOREIGN KEY (wharehouse_id) REFERENCES wharehouse (id)');
        $this->addSql('ALTER TABLE order ADD CONSTRAINT FK_6117D13B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order ADD CONSTRAINT FK_6117D13B51D43F65 FOREIGN KEY (purchased_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sell ADD CONSTRAINT FK_9B9ED07D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE sell ADD CONSTRAINT FK_9B9ED07D148EA8A1 FOREIGN KEY (sold_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_verification ADD CONSTRAINT FK_DA3DB9092A841BBC FOREIGN KEY (requesting_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_verification ADD CONSTRAINT FK_DA3DB90969F4B775 FOREIGN KEY (verified_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature DROP FOREIGN KEY FK_1FD775664584665A');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F894584665A');
        $this->addSql('ALTER TABLE order DROP FOREIGN KEY FK_6117D13B4584665A');
        $this->addSql('ALTER TABLE sell DROP FOREIGN KEY FK_9B9ED07D4584665A');
        $this->addSql('ALTER TABLE order DROP FOREIGN KEY FK_6117D13B51D43F65');
        $this->addSql('ALTER TABLE sell DROP FOREIGN KEY FK_9B9ED07D148EA8A1');
        $this->addSql('ALTER TABLE user_verification DROP FOREIGN KEY FK_DA3DB9092A841BBC');
        $this->addSql('ALTER TABLE user_verification DROP FOREIGN KEY FK_DA3DB90969F4B775');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD9D2A6462');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE order');
        $this->addSql('DROP TABLE sell');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_verification');
        $this->addSql('DROP TABLE wharehouse');
    }
}
