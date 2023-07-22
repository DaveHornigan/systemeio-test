<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230722135854 extends AbstractMigration
{
    private string $tableName = 'product';

    public function getDescription(): string
    {
        return "Create $this->tableName table";
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable($this->tableName);
        $table->addColumn('id', Types::GUID);
        $table->addColumn('name', Types::STRING)->setLength(16);
        $table->addColumn('price', Types::INTEGER)->setUnsigned(true)->setComment('Euro cents');
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE)->setDefault('CURRENT_TIMESTAMP');
        $table->addColumn('updated_at', Types::DATETIME_MUTABLE)->setDefault('CURRENT_TIMESTAMP');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable($this->tableName);
    }
}
