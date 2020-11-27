<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127073736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'creates database and core (flight, reservation, ticket) tables';
    }

    public function up(Schema $schema) : void
    {

        $this->addSql('CREATE SEQUENCE flight_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE flight (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reservation (id INT NOT NULL, flight_id INT NOT NULL, seat_number INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42C8495591F478C5 ON reservation (flight_id)');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, flight_id INT NOT NULL, seat_number INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA391F478C5 ON ticket (flight_id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495591F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA391F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C8495591F478C5');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA391F478C5');
        $this->addSql('DROP SEQUENCE flight_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reservation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE ticket');
    }
}
