<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Section;

final class SectionDcaConfigurator
{
    /**
     * @param array<string,mixed> $dca
     */
    public function apply(array &$dca): void
    {
        $dca['palettes'][SectionFields::TYPE_START]
            = '{type_legend},type,headline;'
            . '{vtxm_section_legend},'.SectionFields::SECTION_TYPE.','.SectionFields::SECTION_PRESET.','.SectionFields::SECTION_STACK_MOBILE.';'
            . '{protected_legend:hide},protected;'
            . '{expert_legend:hide},guests,cssID,space;'
            . '{invisible_legend:hide},invisible,start,stop';

        $dca['palettes'][SectionFields::TYPE_AREA]
            = '{type_legend},type;'
            . '{protected_legend:hide},protected;'
            . '{expert_legend:hide},guests;'
            . '{invisible_legend:hide},invisible,start,stop';

        $dca['palettes'][SectionFields::TYPE_END]
            = '{type_legend},type;'
            . '{protected_legend:hide},protected;'
            . '{expert_legend:hide},guests;'
            . '{invisible_legend:hide},invisible,start,stop';

        $this->addSelector($dca, SectionFields::SECTION_TYPE);
        $this->mergeSubpalette($dca, SectionFields::SECTION_TYPE.'_grid', [
            SectionFields::SECTION_COLUMNS,
            SectionFields::SECTION_GAP,
            SectionFields::SECTION_GRID_ALIGN,
        ]);
        $this->mergeSubpalette($dca, SectionFields::SECTION_TYPE.'_split', [
            SectionFields::SECTION_RATIO,
            SectionFields::SECTION_ALIGN,
            SectionFields::SECTION_DIVIDER,
        ]);

        $this->addFields($dca);
    }

    /**
     * @param array<string,mixed> $dca
     */
    private function addSelector(array &$dca, string $field): void
    {
        $selectors = $dca['palettes']['__selector__'] ?? [];

        if (!\is_array($selectors)) {
            $selectors = \array_filter(\array_map('trim', \explode(',', (string) $selectors)));
        }

        $uniqueSelectors = [];

        foreach ($selectors as $selector) {
            $selector = (string) $selector;

            if ('' !== $selector && !\in_array($selector, $uniqueSelectors, true)) {
                $uniqueSelectors[] = $selector;
            }
        }

        if (!\in_array($field, $uniqueSelectors, true)) {
            $uniqueSelectors[] = $field;
        }

        $dca['palettes']['__selector__'] = $uniqueSelectors;
    }

    /**
     * @param array<string,mixed> $dca
     * @param list<string>        $fields
     */
    private function mergeSubpalette(array &$dca, string $name, array $fields): void
    {
        $existing = $dca['subpalettes'][$name] ?? '';
        $merged = [];

        foreach (\array_merge(\explode(',', (string) $existing), $fields) as $field) {
            $field = \trim((string) $field);

            if ('' !== $field && !\in_array($field, $merged, true)) {
                $merged[] = $field;
            }
        }

        $dca['subpalettes'][$name] = \implode(',', $merged);
    }

    /**
     * @param array<string,mixed> $dca
     */
    private function addFields(array &$dca): void
    {
        $dca['fields'][SectionFields::SECTION_TYPE] = [
            'exclude' => true,
            'default' => SectionFields::DEFAULTS[SectionFields::SECTION_TYPE],
            'inputType' => 'select',
            'options' => SectionFields::SECTION_TYPES,
            'reference' => &$GLOBALS['TL_LANG']['tl_content']['vtxmSectionTypeOptions'],
            'eval' => [
                'chosen' => true,
                'tl_class' => 'w50',
                'submitOnChange' => true,
            ],
            'sql' => "varchar(16) NOT NULL default ''",
        ];

        $dca['fields'][SectionFields::SECTION_PRESET] = [
            'exclude' => true,
            'default' => SectionFields::DEFAULTS[SectionFields::SECTION_PRESET],
            'inputType' => 'select',
            'options' => SectionFields::PRESETS,
            'reference' => &$GLOBALS['TL_LANG']['tl_content']['vtxmSectionPresetOptions'],
            'eval' => [
                'chosen' => true,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(32) NOT NULL default ''",
        ];

        $dca['fields'][SectionFields::SECTION_COLUMNS] = [
            'exclude' => true,
            'default' => SectionFields::DEFAULTS[SectionFields::SECTION_COLUMNS],
            'inputType' => 'select',
            'options' => SectionFields::COLUMNS,
            'reference' => &$GLOBALS['TL_LANG']['tl_content']['vtxmSectionColumnsOptions'],
            'eval' => [
                'chosen' => true,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(8) NOT NULL default ''",
        ];

        $dca['fields'][SectionFields::SECTION_GAP] = [
            'exclude' => true,
            'default' => SectionFields::DEFAULTS[SectionFields::SECTION_GAP],
            'inputType' => 'select',
            'options' => SectionFields::GAPS,
            'reference' => &$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGapOptions'],
            'eval' => [
                'chosen' => true,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(16) NOT NULL default ''",
        ];

        $dca['fields'][SectionFields::SECTION_GRID_ALIGN] = [
            'exclude' => true,
            'default' => SectionFields::DEFAULTS[SectionFields::SECTION_GRID_ALIGN],
            'inputType' => 'select',
            'options' => SectionFields::GRID_ALIGNMENTS,
            'reference' => &$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGridAlignOptions'],
            'eval' => [
                'chosen' => true,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(16) NOT NULL default ''",
        ];

        $dca['fields'][SectionFields::SECTION_RATIO] = [
            'exclude' => true,
            'default' => SectionFields::DEFAULTS[SectionFields::SECTION_RATIO],
            'inputType' => 'select',
            'options' => SectionFields::RATIOS,
            'reference' => &$GLOBALS['TL_LANG']['tl_content']['vtxmSectionRatioOptions'],
            'eval' => [
                'chosen' => true,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(16) NOT NULL default ''",
        ];

        $dca['fields'][SectionFields::SECTION_ALIGN] = [
            'exclude' => true,
            'default' => SectionFields::DEFAULTS[SectionFields::SECTION_ALIGN],
            'inputType' => 'select',
            'options' => SectionFields::ALIGNMENTS,
            'reference' => &$GLOBALS['TL_LANG']['tl_content']['vtxmSectionAlignOptions'],
            'eval' => [
                'chosen' => true,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(16) NOT NULL default ''",
        ];

        $dca['fields'][SectionFields::SECTION_DIVIDER] = [
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50 m12',
            ],
            'sql' => "char(1) NOT NULL default ''",
        ];

        $dca['fields'][SectionFields::SECTION_STACK_MOBILE] = [
            'exclude' => true,
            'default' => SectionFields::DEFAULTS[SectionFields::SECTION_STACK_MOBILE],
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50 m12',
            ],
            'sql' => "char(1) NOT NULL default ''",
        ];
    }
}
