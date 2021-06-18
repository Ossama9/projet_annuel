<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529111906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature DROP FOREIGN KEY FK_1FD775664584665A');
        $this->addSql('DROP INDEX UNIQ_1FD775664584665A ON feature');
        $this->addSql('ALTER TABLE feature DROP product_id');
        $this->addSql('ALTER TABLE model ADD feature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D960E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id)');
        $this->addSql('CREATE INDEX IDX_D79572D960E4B879 ON model (feature_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD53C674EE');
        $this->addSql('DROP INDEX UNIQ_D34A04AD53C674EE ON product');
        $this->addSql('ALTER TABLE product CHANGE offer_id model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD7975B7E7 ON product (model_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE feature ADD CONSTRAINT FK_1FD775664584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FD775664584665A ON feature (product_id)');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D960E4B879');
        $this->addSql('DROP INDEX IDX_D79572D960E4B879 ON model');
        $this->addSql('ALTER TABLE model DROP feature_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7975B7E7');
        $this->addSql('DROP INDEX IDX_D34A04AD7975B7E7 ON product');
        $this->addSql('ALTER TABLE product CHANGE model_id offer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD53C674EE ON product (offer_id)');
    }
}
