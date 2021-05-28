<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210528202419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D9A090B42E');
        $this->addSql('DROP INDEX IDX_D79572D9A090B42E ON model');
        $this->addSql('ALTER TABLE model DROP offers_id');
        $this->addSql('ALTER TABLE offer ADD model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_29D6873E7975B7E7 ON offer (model_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model ADD offers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D9A090B42E FOREIGN KEY (offers_id) REFERENCES offer (id)');
        $this->addSql('CREATE INDEX IDX_D79572D9A090B42E ON model (offers_id)');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E7975B7E7');
        $this->addSql('DROP INDEX IDX_29D6873E7975B7E7 ON offer');
        $this->addSql('ALTER TABLE offer DROP model_id');
    }
}
