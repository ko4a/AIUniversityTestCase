<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127125824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'adds field is sales completed';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE flight ADD sales_completed BOOLEAN NOT NULL default false');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE flight DROP sales_completed');
    }
}
