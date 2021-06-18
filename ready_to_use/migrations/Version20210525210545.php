<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525210545 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, foundation_date DATE DEFAULT NULL, location VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, release_date DATE DEFAULT NULL, INDEX IDX_D79572D944F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, product_condition INT NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_model (offer_id INT NOT NULL, model_id INT NOT NULL, INDEX IDX_54B80F3053C674EE (offer_id), INDEX IDX_54B80F307975B7E7 (model_id), PRIMARY KEY(offer_id, model_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE offer_model ADD CONSTRAINT FK_54B80F3053C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_model ADD CONSTRAINT FK_54B80F307975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feature CHANGE battery battery INT DEFAULT NULL, CHANGE camera camera VARCHAR(30) DEFAULT NULL, CHANGE graphic_card graphic_card VARCHAR(30) DEFAULT NULL, CHANGE hard_disk hard_disk VARCHAR(30) DEFAULT NULL, CHANGE os_version os_version VARCHAR(30) DEFAULT NULL, CHANGE processor processor VARCHAR(30) DEFAULT NULL, CHANGE ram ram INT DEFAULT NULL, CHANGE screen_size screen_size VARCHAR(30) DEFAULT NULL, CHANGE tactile tactile TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE sell ADD counter_offer DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE wharehouse ADD city VARCHAR(30) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE offer_model DROP FOREIGN KEY FK_54B80F307975B7E7');
        $this->addSql('ALTER TABLE offer_model DROP FOREIGN KEY FK_54B80F3053C674EE');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE offer_model');
        $this->addSql('ALTER TABLE feature CHANGE battery battery VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE camera camera VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE graphic_card graphic_card VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE hard_disk hard_disk VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE os_version os_version VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE processor processor VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ram ram VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE screen_size screen_size VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tactile tactile VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sell DROP counter_offer');
        $this->addSql('ALTER TABLE wharehouse DROP city');
    }
}
