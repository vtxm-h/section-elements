<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Vendor\SectionElementsBundle\Section\SectionFields;

final class LegacySectionFieldsMigration extends AbstractMigration
{
    private const NEW_FIELD_SQL = [
        SectionFields::SECTION_TYPE => "VARCHAR(16) NOT NULL DEFAULT ''",
        SectionFields::SECTION_PRESET => "VARCHAR(32) NOT NULL DEFAULT ''",
        SectionFields::SECTION_COLUMNS => "VARCHAR(8) NOT NULL DEFAULT ''",
        SectionFields::SECTION_GAP => "VARCHAR(16) NOT NULL DEFAULT ''",
        SectionFields::SECTION_GRID_ALIGN => "VARCHAR(16) NOT NULL DEFAULT ''",
        SectionFields::SECTION_RATIO => "VARCHAR(16) NOT NULL DEFAULT ''",
        SectionFields::SECTION_ALIGN => "VARCHAR(16) NOT NULL DEFAULT ''",
        SectionFields::SECTION_DIVIDER => "CHAR(1) NOT NULL DEFAULT ''",
        SectionFields::SECTION_STACK_MOBILE => "CHAR(1) NOT NULL DEFAULT ''",
    ];

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getName(): string
    {
        return 'Migrate VTXM section element fields to bundle-specific tl_content columns';
    }

    public function shouldRun(): bool
    {
        $columns = $this->getColumns();

        if ([] === $columns || !$this->hasAnyLegacyColumn($columns)) {
            return false;
        }

        if ($this->hasMissingNewColumns($columns)) {
            return true;
        }

        return $this->hasUninitializedStartRows($columns);
    }

    public function run(): MigrationResult
    {
        $columns = $this->getColumns();
        $createdColumns = 0;
        $affectedRows = 0;

        if ([] === $columns || !$this->hasAnyLegacyColumn($columns)) {
            return $this->createResult(true, 'No legacy VTXM section fields found.');
        }

        $columns = $this->ensureNewColumns($columns, $createdColumns);
        $ids = $this->getUninitializedStartIds($columns);

        if ([] !== $ids) {
            $idList = \implode(',', $ids);

            foreach (SectionFields::LEGACY_FIELD_MAP as $newField => $legacyField) {
                if (!$this->hasColumn($columns, $newField) || !$this->hasColumn($columns, $legacyField)) {
                    continue;
                }

                $affectedRows += $this->connection->executeStatement(
                    \sprintf(
                        'UPDATE %s SET %s = %s WHERE %s IN (%s) AND (%s IS NULL OR %s = \'\') AND %s IS NOT NULL AND %s <> \'\'',
                        $this->quote('tl_content'),
                        $this->quote($newField),
                        $this->quote($legacyField),
                        $this->quote('id'),
                        $idList,
                        $this->quote($newField),
                        $this->quote($newField),
                        $this->quote($legacyField),
                        $this->quote($legacyField)
                    )
                );
            }

            foreach (SectionFields::DEFAULTS as $newField => $default) {
                if ('' === $default || !$this->hasColumn($columns, $newField)) {
                    continue;
                }

                $affectedRows += $this->connection->executeStatement(
                    \sprintf(
                        'UPDATE %s SET %s = :defaultValue WHERE %s IN (%s) AND (%s IS NULL OR %s = \'\')',
                        $this->quote('tl_content'),
                        $this->quote($newField),
                        $this->quote('id'),
                        $idList,
                        $this->quote($newField),
                        $this->quote($newField)
                    ),
                    ['defaultValue' => $default]
                );
            }
        }

        $message = \sprintf('Migrated %d VTXM section field value(s).', $affectedRows);

        if ($createdColumns > 0) {
            $message .= \sprintf(' Created %d missing VTXM section column(s) before the schema diff.', $createdColumns);
        }

        return $this->createResult(true, $message);
    }

    /**
     * @return array<string,true>
     */
    private function getColumns(): array
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (!$schemaManager->tablesExist(['tl_content'])) {
            return [];
        }

        $columns = [];

        foreach (\array_keys($schemaManager->listTableColumns('tl_content')) as $column) {
            $columns[\strtolower($column)] = true;
        }

        return $columns;
    }

    /**
     * @param array<string,true> $columns
     */
    private function hasUninitializedStartRows(array $columns): bool
    {
        return [] !== $this->getUninitializedStartIds($columns);
    }

    /**
     * @param array<string,true> $columns
     *
     * @return list<int>
     */
    private function getUninitializedStartIds(array $columns): array
    {
        $condition = $this->buildUninitializedFieldsCondition($columns);

        if ('' === $condition) {
            return [];
        }

        $sql = \sprintf(
            'SELECT %s FROM %s WHERE %s = :type AND %s',
            $this->quote('id'),
            $this->quote('tl_content'),
            $this->quote('type'),
            $condition
        );

        return \array_values(\array_map(
            static fn ($id): int => (int) $id,
            $this->connection->fetchFirstColumn($sql, ['type' => SectionFields::TYPE_START])
        ));
    }

    /**
     * @param array<string,true> $columns
     */
    private function buildUninitializedFieldsCondition(array $columns): string
    {
        $conditions = [];

        foreach (\array_keys(self::NEW_FIELD_SQL) as $field) {
            if (!$this->hasColumn($columns, $field)) {
                continue;
            }

            $conditions[] = \sprintf(
                '(%s IS NULL OR %s = \'\')',
                $this->quote($field),
                $this->quote($field)
            );
        }

        return \implode(' AND ', $conditions);
    }

    /**
     * @param array<string,true> $columns
     *
     * @return array<string,true>
     */
    private function ensureNewColumns(array $columns, int &$createdColumns): array
    {
        foreach (self::NEW_FIELD_SQL as $field => $sql) {
            if ($this->hasColumn($columns, $field)) {
                continue;
            }

            $this->connection->executeStatement(
                \sprintf(
                    'ALTER TABLE %s ADD %s %s',
                    $this->quote('tl_content'),
                    $this->quote($field),
                    $sql
                )
            );

            $columns[\strtolower($field)] = true;
            ++$createdColumns;
        }

        return $columns;
    }

    /**
     * @param array<string,true> $columns
     */
    private function hasMissingNewColumns(array $columns): bool
    {
        foreach (\array_keys(self::NEW_FIELD_SQL) as $field) {
            if (!$this->hasColumn($columns, $field)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<string,true> $columns
     */
    private function hasAnyLegacyColumn(array $columns): bool
    {
        foreach (SectionFields::LEGACY_FIELD_MAP as $legacyField) {
            if ($this->hasColumn($columns, $legacyField)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<string,true> $columns
     */
    private function hasColumn(array $columns, string $column): bool
    {
        return isset($columns[\strtolower($column)]);
    }

    private function quote(string $identifier): string
    {
        return $this->connection->quoteIdentifier($identifier);
    }
}
