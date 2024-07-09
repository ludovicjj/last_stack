<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706174846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE planet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE voyage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planet (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, light_years_from_earth DOUBLE PRECISION NOT NULL, image_filename VARCHAR(255) NOT NULL, is_in_milky_way BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE voyage (id INT NOT NULL, planet_id INT NOT NULL, purpose VARCHAR(255) NOT NULL, wormhole_upgrade BOOLEAN NOT NULL, leave_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3F9D8955A25E9820 ON voyage (planet_id)');
        $this->addSql('COMMENT ON COLUMN voyage.leave_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955A25E9820 FOREIGN KEY (planet_id) REFERENCES planet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE planet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE voyage_id_seq CASCADE');
        $this->addSql('ALTER TABLE voyage DROP CONSTRAINT FK_3F9D8955A25E9820');
        $this->addSql('DROP TABLE planet');
        $this->addSql('DROP TABLE voyage');
    }
}
