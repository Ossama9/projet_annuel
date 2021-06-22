<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618092618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_IDASSO');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE asso');
        $this->addSql('DROP TABLE projet');
        $this->addSql('ALTER TABLE feature CHANGE battery battery VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D960E4B879');
        $this->addSql('DROP INDEX IDX_D79572D960E4B879 ON model');
        $this->addSql('ALTER TABLE model ADD show_battery_field TINYINT(1) NOT NULL, ADD show_camera_field TINYINT(1) NOT NULL, ADD show_graphic_card_field TINYINT(1) NOT NULL, ADD show_hard_disk_field TINYINT(1) NOT NULL, ADD show_os_version_field TINYINT(1) NOT NULL, ADD show_processor_field TINYINT(1) NOT NULL, ADD show_ram_field TINYINT(1) NOT NULL, ADD show_screen_field TINYINT(1) NOT NULL, ADD show_tactile_field TINYINT(1) NOT NULL, CHANGE feature_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D79572D912469DE2 ON model (category_id)');
        $this->addSql('ALTER TABLE order_item DROP quantity');
        $this->addSql('ALTER TABLE product ADD feature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD60E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD60E4B879 ON product (feature_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D912469DE2');
        $this->addSql('CREATE TABLE asso (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nameAsso VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, email_contact VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, status INT NOT NULL, INDEX fk_user (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, id_asso INT NOT NULL, nameProjet VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, descriptif VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, tarif INT NOT NULL, INDEX FK_IDASSO (id_asso), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE asso ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_IDASSO FOREIGN KEY (id_asso) REFERENCES asso (id)');
        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE feature CHANGE battery battery INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_D79572D912469DE2 ON model');
        $this->addSql('ALTER TABLE model DROP show_battery_field, DROP show_camera_field, DROP show_graphic_card_field, DROP show_hard_disk_field, DROP show_os_version_field, DROP show_processor_field, DROP show_ram_field, DROP show_screen_field, DROP show_tactile_field, CHANGE category_id feature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D960E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id)');
        $this->addSql('CREATE INDEX IDX_D79572D960E4B879 ON model (feature_id)');
        $this->addSql('ALTER TABLE order_item ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD60E4B879');
        $this->addSql('DROP INDEX IDX_D34A04AD60E4B879 ON product');
        $this->addSql('ALTER TABLE product DROP feature_id');
    }
}
