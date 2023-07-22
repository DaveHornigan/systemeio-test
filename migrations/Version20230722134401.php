<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230722134401 extends AbstractMigration
{
    private string $tableName = 'tax';

    public function getDescription(): string
    {
        return "Create $this->tableName table";
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable($this->tableName);
        $table->addColumn('id', Types::GUID);
        $table->addColumn('country_name', Types::STRING)->setLength(32);
        $table->addColumn('country_code', Types::STRING)->setLength(3);
        $table->addColumn('tax_percent', Types::SMALLINT)->setUnsigned(true);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable($this->tableName);
    }
}
