<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Section;

final class SectionFields
{
    public const TYPE_START = 'vtxm_section_start';
    public const TYPE_AREA = 'vtxm_section_area';
    public const TYPE_END = 'vtxm_section_end';

    public const SECTION_TYPE = 'vtxmSectionType';
    public const SECTION_PRESET = 'vtxmSectionPreset';
    public const SECTION_COLUMNS = 'vtxmSectionColumns';
    public const SECTION_GAP = 'vtxmSectionGap';
    public const SECTION_GRID_ALIGN = 'vtxmSectionGridAlign';
    public const SECTION_RATIO = 'vtxmSectionRatio';
    public const SECTION_ALIGN = 'vtxmSectionAlign';
    public const SECTION_DIVIDER = 'vtxmSectionDivider';
    public const SECTION_STACK_MOBILE = 'vtxmSectionStackMobile';

    public const LEGACY_SECTION_TYPE = 'sectionType';
    public const LEGACY_SECTION_PRESET = 'sectionPreset';
    public const LEGACY_SECTION_COLUMNS = 'sectionColumns';
    public const LEGACY_SECTION_GAP = 'sectionGap';
    public const LEGACY_SECTION_GRID_ALIGN = 'sectionGridAlign';
    public const LEGACY_SECTION_RATIO = 'sectionRatio';
    public const LEGACY_SECTION_ALIGN = 'sectionAlign';
    public const LEGACY_SECTION_DIVIDER = 'sectionDivider';
    public const LEGACY_SECTION_STACK_MOBILE = 'sectionStackMobile';

    public const SECTION_TYPES = ['grid', 'split'];
    public const PRESETS = ['default', 'about', 'contact', 'spotlight'];
    public const COLUMNS = ['2', '3', '4'];
    public const GAPS = ['small', 'medium', 'large'];
    public const GRID_ALIGNMENTS = ['start', 'center', 'stretch'];
    public const RATIOS = ['50-50', '60-40', '40-60', '70-30', '30-70'];
    public const ALIGNMENTS = ['start', 'center'];
    public const HEADLINE_UNITS = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

    public const DEFAULTS = [
        self::SECTION_TYPE => 'grid',
        self::SECTION_PRESET => 'default',
        self::SECTION_COLUMNS => '3',
        self::SECTION_GAP => 'medium',
        self::SECTION_GRID_ALIGN => 'stretch',
        self::SECTION_RATIO => '50-50',
        self::SECTION_ALIGN => 'start',
        self::SECTION_DIVIDER => '',
        self::SECTION_STACK_MOBILE => '1',
    ];

    public const LEGACY_FIELD_MAP = [
        self::SECTION_TYPE => self::LEGACY_SECTION_TYPE,
        self::SECTION_PRESET => self::LEGACY_SECTION_PRESET,
        self::SECTION_COLUMNS => self::LEGACY_SECTION_COLUMNS,
        self::SECTION_GAP => self::LEGACY_SECTION_GAP,
        self::SECTION_GRID_ALIGN => self::LEGACY_SECTION_GRID_ALIGN,
        self::SECTION_RATIO => self::LEGACY_SECTION_RATIO,
        self::SECTION_ALIGN => self::LEGACY_SECTION_ALIGN,
        self::SECTION_DIVIDER => self::LEGACY_SECTION_DIVIDER,
        self::SECTION_STACK_MOBILE => self::LEGACY_SECTION_STACK_MOBILE,
    ];

    public static function isStructuralType(string $type): bool
    {
        return \in_array($type, [self::TYPE_START, self::TYPE_AREA, self::TYPE_END], true);
    }

    /**
     * @param array<string,mixed> $row
     * @param list<string>        $allowed
     */
    public static function option(array $row, string $field, array $allowed, string $default): string
    {
        $legacyField = self::LEGACY_FIELD_MAP[$field] ?? null;
        $value = self::rawValue($row, $field, $legacyField);

        return \in_array($value, $allowed, true) ? $value : $default;
    }

    /**
     * @param array<string,mixed> $row
     */
    public static function checkbox(array $row, string $field, bool $default): bool
    {
        if (\array_key_exists($field, $row)) {
            return '1' === \trim((string) $row[$field]);
        }

        $legacyField = self::LEGACY_FIELD_MAP[$field] ?? null;
        $value = self::rawValue($row, $field, $legacyField);

        if ('' === $value) {
            return $default;
        }

        return '1' === $value;
    }

    /**
     * @param array<string,mixed> $row
     */
    public static function sectionType(array $row): string
    {
        return self::option($row, self::SECTION_TYPE, self::SECTION_TYPES, self::DEFAULTS[self::SECTION_TYPE]);
    }

    /**
     * @param array<string,mixed> $row
     */
    private static function rawValue(array $row, string $field, ?string $legacyField): string
    {
        if (\array_key_exists($field, $row)) {
            return \trim((string) $row[$field]);
        }

        if (null === $legacyField || !\array_key_exists($legacyField, $row)) {
            return '';
        }

        return \trim((string) $row[$legacyField]);
    }
}
