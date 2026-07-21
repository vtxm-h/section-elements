<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Tests\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\TestCase;
use Vendor\SectionElementsBundle\Migration\LegacySectionFieldsMigration;
use Vendor\SectionElementsBundle\Section\SectionFields;

final class LegacySectionFieldsMigrationTest extends TestCase
{
    private Connection $connection;

    protected function setUp(): void
    {
        $this->connection = DriverManager::getConnection(['driver' => 'pdo_sqlite', 'memory' => true]);
        $this->createTable();
    }

    public function testLegacyDataMigrationCopiesOldValuesAndPreservesDefaults(): void
    {
        $this->insertRow([
            'id' => 1,
            'type' => SectionFields::TYPE_START,
            'sectionType' => 'split',
            'sectionPreset' => 'spotlight',
            'sectionColumns' => '4',
            'sectionGap' => 'large',
            'sectionGridAlign' => 'center',
            'sectionRatio' => '70-30',
            'sectionAlign' => 'center',
            'sectionDivider' => '1',
            'sectionStackMobile' => '1',
        ]);
        $this->insertRow([
            'id' => 2,
            'type' => SectionFields::TYPE_START,
        ]);

        $migration = new LegacySectionFieldsMigration($this->connection);

        self::assertTrue($migration->shouldRun());
        $result = $migration->run();

        self::assertTrue($result->isSuccessful());

        $migrated = $this->fetchRow(1);
        self::assertSame('split', $migrated[SectionFields::SECTION_TYPE]);
        self::assertSame('spotlight', $migrated[SectionFields::SECTION_PRESET]);
        self::assertSame('4', $migrated[SectionFields::SECTION_COLUMNS]);
        self::assertSame('large', $migrated[SectionFields::SECTION_GAP]);
        self::assertSame('center', $migrated[SectionFields::SECTION_GRID_ALIGN]);
        self::assertSame('70-30', $migrated[SectionFields::SECTION_RATIO]);
        self::assertSame('center', $migrated[SectionFields::SECTION_ALIGN]);
        self::assertSame('1', $migrated[SectionFields::SECTION_DIVIDER]);
        self::assertSame('1', $migrated[SectionFields::SECTION_STACK_MOBILE]);

        $defaulted = $this->fetchRow(2);
        self::assertSame('grid', $defaulted[SectionFields::SECTION_TYPE]);
        self::assertSame('default', $defaulted[SectionFields::SECTION_PRESET]);
        self::assertSame('3', $defaulted[SectionFields::SECTION_COLUMNS]);
        self::assertSame('medium', $defaulted[SectionFields::SECTION_GAP]);
        self::assertSame('stretch', $defaulted[SectionFields::SECTION_GRID_ALIGN]);
        self::assertSame('50-50', $defaulted[SectionFields::SECTION_RATIO]);
        self::assertSame('start', $defaulted[SectionFields::SECTION_ALIGN]);
        self::assertSame('', $defaulted[SectionFields::SECTION_DIVIDER]);
        self::assertSame('1', $defaulted[SectionFields::SECTION_STACK_MOBILE]);
    }

    public function testMigrationDoesNotOverwriteAlreadyPopulatedNewFields(): void
    {
        $this->insertRow([
            'id' => 1,
            'type' => SectionFields::TYPE_START,
            'sectionType' => 'split',
            SectionFields::SECTION_TYPE => 'grid',
            'sectionPreset' => 'spotlight',
            SectionFields::SECTION_PRESET => 'contact',
            'sectionDivider' => '1',
            SectionFields::SECTION_DIVIDER => '',
        ]);

        $migration = new LegacySectionFieldsMigration($this->connection);

        self::assertFalse($migration->shouldRun());
        $migration->run();

        $row = $this->fetchRow(1);
        self::assertSame('grid', $row[SectionFields::SECTION_TYPE]);
        self::assertSame('contact', $row[SectionFields::SECTION_PRESET]);
        self::assertSame('', $row[SectionFields::SECTION_DIVIDER]);
    }

    public function testMigrationDoesNotRestoreClearedNewCheckboxesWhenLegacyColumnsRemain(): void
    {
        $this->insertRow([
            'id' => 1,
            'type' => SectionFields::TYPE_START,
            'sectionType' => 'split',
            'sectionStackMobile' => '1',
            SectionFields::SECTION_TYPE => 'grid',
            SectionFields::SECTION_PRESET => 'default',
            SectionFields::SECTION_COLUMNS => '3',
            SectionFields::SECTION_GAP => 'medium',
            SectionFields::SECTION_GRID_ALIGN => 'stretch',
            SectionFields::SECTION_RATIO => '50-50',
            SectionFields::SECTION_ALIGN => 'start',
            SectionFields::SECTION_DIVIDER => '',
            SectionFields::SECTION_STACK_MOBILE => '',
        ]);

        $migration = new LegacySectionFieldsMigration($this->connection);

        self::assertFalse($migration->shouldRun());
        $migration->run();

        $row = $this->fetchRow(1);
        self::assertSame('', $row[SectionFields::SECTION_STACK_MOBILE]);
    }

    public function testMigrationCreatesMissingNewColumnsBeforeSchemaDeletesCanRemoveLegacyColumns(): void
    {
        $this->connection->executeStatement('DROP TABLE tl_content');
        $this->createLegacyOnlyTable();
        $this->insertLegacyOnlyRow([
            'id' => 1,
            'type' => SectionFields::TYPE_START,
            'sectionType' => 'split',
            'sectionPreset' => 'spotlight',
            'sectionColumns' => '4',
            'sectionGap' => 'large',
            'sectionGridAlign' => 'center',
            'sectionRatio' => '70-30',
            'sectionAlign' => 'center',
            'sectionDivider' => '1',
            'sectionStackMobile' => '1',
        ]);

        $migration = new LegacySectionFieldsMigration($this->connection);

        self::assertTrue($migration->shouldRun());
        $result = $migration->run();

        self::assertTrue($result->isSuccessful());

        $columns = $this->listColumns();
        foreach (SectionFields::LEGACY_FIELD_MAP as $newField => $legacyField) {
            self::assertContains(\strtolower($legacyField), $columns);
            self::assertContains(\strtolower($newField), $columns);
        }

        $migrated = $this->fetchRow(1);
        self::assertSame('split', $migrated[SectionFields::SECTION_TYPE]);
        self::assertSame('spotlight', $migrated[SectionFields::SECTION_PRESET]);
        self::assertSame('4', $migrated[SectionFields::SECTION_COLUMNS]);
        self::assertSame('large', $migrated[SectionFields::SECTION_GAP]);
        self::assertSame('center', $migrated[SectionFields::SECTION_GRID_ALIGN]);
        self::assertSame('70-30', $migrated[SectionFields::SECTION_RATIO]);
        self::assertSame('center', $migrated[SectionFields::SECTION_ALIGN]);
        self::assertSame('1', $migrated[SectionFields::SECTION_DIVIDER]);
        self::assertSame('1', $migrated[SectionFields::SECTION_STACK_MOBILE]);
        self::assertFalse($migration->shouldRun());
    }

    public function testMigrationIsIdempotent(): void
    {
        $this->insertRow([
            'id' => 1,
            'type' => SectionFields::TYPE_START,
            'sectionType' => 'split',
        ]);

        $migration = new LegacySectionFieldsMigration($this->connection);

        self::assertTrue($migration->shouldRun());
        $migration->run();
        self::assertFalse($migration->shouldRun());

        $first = $this->fetchRow(1);
        $migration->run();
        $second = $this->fetchRow(1);

        self::assertSame($first, $second);
    }

    public function testMigrationIsIsolatedToSectionElementRecords(): void
    {
        $this->insertRow([
            'id' => 1,
            'type' => 'text',
            'sectionType' => 'split',
            'sectionPreset' => 'spotlight',
        ]);
        $this->insertRow([
            'id' => 2,
            'type' => SectionFields::TYPE_AREA,
            'sectionType' => 'split',
            'sectionPreset' => 'spotlight',
        ]);
        $this->insertRow([
            'id' => 3,
            'type' => SectionFields::TYPE_END,
            'sectionType' => 'split',
            'sectionPreset' => 'spotlight',
        ]);

        $migration = new LegacySectionFieldsMigration($this->connection);

        self::assertFalse($migration->shouldRun());
        $migration->run();

        self::assertSame('', $this->fetchRow(1)[SectionFields::SECTION_TYPE]);
        self::assertSame('', $this->fetchRow(2)[SectionFields::SECTION_TYPE]);
        self::assertSame('', $this->fetchRow(3)[SectionFields::SECTION_TYPE]);
    }

    private function createTable(): void
    {
        $this->connection->executeStatement(
            'CREATE TABLE tl_content (
                id INTEGER PRIMARY KEY,
                type VARCHAR(64) NOT NULL DEFAULT \'\',
                sectionType VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionPreset VARCHAR(32) NOT NULL DEFAULT \'\',
                sectionColumns VARCHAR(8) NOT NULL DEFAULT \'\',
                sectionGap VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionGridAlign VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionRatio VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionAlign VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionDivider CHAR(1) NOT NULL DEFAULT \'\',
                sectionStackMobile CHAR(1) NOT NULL DEFAULT \'\',
                vtxmSectionType VARCHAR(16) NOT NULL DEFAULT \'\',
                vtxmSectionPreset VARCHAR(32) NOT NULL DEFAULT \'\',
                vtxmSectionColumns VARCHAR(8) NOT NULL DEFAULT \'\',
                vtxmSectionGap VARCHAR(16) NOT NULL DEFAULT \'\',
                vtxmSectionGridAlign VARCHAR(16) NOT NULL DEFAULT \'\',
                vtxmSectionRatio VARCHAR(16) NOT NULL DEFAULT \'\',
                vtxmSectionAlign VARCHAR(16) NOT NULL DEFAULT \'\',
                vtxmSectionDivider CHAR(1) NOT NULL DEFAULT \'\',
                vtxmSectionStackMobile CHAR(1) NOT NULL DEFAULT \'\'
            )'
        );
    }

    private function createLegacyOnlyTable(): void
    {
        $this->connection->executeStatement(
            'CREATE TABLE tl_content (
                id INTEGER PRIMARY KEY,
                type VARCHAR(64) NOT NULL DEFAULT \'\',
                sectionType VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionPreset VARCHAR(32) NOT NULL DEFAULT \'\',
                sectionColumns VARCHAR(8) NOT NULL DEFAULT \'\',
                sectionGap VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionGridAlign VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionRatio VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionAlign VARCHAR(16) NOT NULL DEFAULT \'\',
                sectionDivider CHAR(1) NOT NULL DEFAULT \'\',
                sectionStackMobile CHAR(1) NOT NULL DEFAULT \'\'
            )'
        );
    }

    /**
     * @param array<string,mixed> $values
     */
    private function insertRow(array $values): void
    {
        $defaults = [
            'id' => null,
            'type' => '',
            'sectionType' => '',
            'sectionPreset' => '',
            'sectionColumns' => '',
            'sectionGap' => '',
            'sectionGridAlign' => '',
            'sectionRatio' => '',
            'sectionAlign' => '',
            'sectionDivider' => '',
            'sectionStackMobile' => '',
            SectionFields::SECTION_TYPE => '',
            SectionFields::SECTION_PRESET => '',
            SectionFields::SECTION_COLUMNS => '',
            SectionFields::SECTION_GAP => '',
            SectionFields::SECTION_GRID_ALIGN => '',
            SectionFields::SECTION_RATIO => '',
            SectionFields::SECTION_ALIGN => '',
            SectionFields::SECTION_DIVIDER => '',
            SectionFields::SECTION_STACK_MOBILE => '',
        ];

        $data = \array_merge($defaults, $values);

        $this->connection->insert('tl_content', $data);
    }

    /**
     * @param array<string,mixed> $values
     */
    private function insertLegacyOnlyRow(array $values): void
    {
        $defaults = [
            'id' => null,
            'type' => '',
            'sectionType' => '',
            'sectionPreset' => '',
            'sectionColumns' => '',
            'sectionGap' => '',
            'sectionGridAlign' => '',
            'sectionRatio' => '',
            'sectionAlign' => '',
            'sectionDivider' => '',
            'sectionStackMobile' => '',
        ];

        $data = \array_merge($defaults, $values);

        $this->connection->insert('tl_content', $data);
    }

    /**
     * @return list<string>
     */
    private function listColumns(): array
    {
        return \array_map(
            static fn (string $column): string => \strtolower($column),
            \array_keys($this->connection->createSchemaManager()->listTableColumns('tl_content'))
        );
    }

    /**
     * @return array<string,string>
     */
    private function fetchRow(int $id): array
    {
        $row = $this->connection->fetchAssociative('SELECT * FROM tl_content WHERE id = ?', [$id]);
        self::assertIsArray($row);

        return \array_map(static fn ($value): string => (string) $value, $row);
    }
}
