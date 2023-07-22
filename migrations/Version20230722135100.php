<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230722135100 extends AbstractMigration
{
    private string $tableName = 'coupon';

    public function getDescription(): string
    {
        return "Create $this->tableName table";
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable($this->tableName);
        $table->addColumn('id', Types::GUID);
        $table->addColumn('code', Types::STRING)->setLength(32);
        $table->addColumn('type', Types::STRING)->setLength(16);
        $table->addColumn('value', Types::SMALLINT)->setUnsigned(true)->setComment('Percent or Euro cents');
        $table->addColumn('expired_at', Types::DATETIME_MUTABLE);
        $table->addColumn('used_at', Types::DATETIME_IMMUTABLE)->setNotnull(false);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE)->setDefault('CURRENT_TIMESTAMP');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable($this->tableName);
    }
}
