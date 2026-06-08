<?php

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_section_start']
    = '{type_legend},type,headline;'
    . '{section_legend},sectionType,sectionPreset,sectionStackMobile;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests,cssID,space;'
    . '{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_section_area']
    = '{type_legend},type;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests;'
    . '{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['vtxm_section_end']
    = '{type_legend},type;'
    . '{protected_legend:hide},protected;'
    . '{expert_legend:hide},guests;'
    . '{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'sectionType';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['sectionType_grid'] = 'sectionColumns,sectionGap,sectionGridAlign';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['sectionType_split'] = 'sectionRatio,sectionAlign,sectionDivider';

$GLOBALS['TL_DCA']['tl_content']['fields']['sectionType'] = [
    'exclude' => true,
    'default' => 'grid',
    'inputType' => 'select',
    'options' => ['grid', 'split'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sectionTypeOptions'],
    'eval' => [
        'chosen' => true,
        'tl_class' => 'w50',
        'submitOnChange' => true,
    ],
    'sql' => "varchar(16) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sectionPreset'] = [
    'exclude' => true,
    'default' => 'default',
    'inputType' => 'select',
    'options' => ['default', 'about', 'contact', 'spotlight'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sectionPresetOptions'],
    'eval' => [
        'chosen' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sectionColumns'] = [
    'exclude' => true,
    'default' => '3',
    'inputType' => 'select',
    'options' => ['2', '3', '4'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sectionColumnsOptions'],
    'eval' => [
        'chosen' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(8) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sectionGap'] = [
    'exclude' => true,
    'default' => 'medium',
    'inputType' => 'select',
    'options' => ['small', 'medium', 'large'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sectionGapOptions'],
    'eval' => [
        'chosen' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(16) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sectionGridAlign'] = [
    'exclude' => true,
    'default' => 'stretch',
    'inputType' => 'select',
    'options' => ['start', 'center', 'stretch'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sectionGridAlignOptions'],
    'eval' => [
        'chosen' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(16) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sectionRatio'] = [
    'exclude' => true,
    'default' => '50-50',
    'inputType' => 'select',
    'options' => ['50-50', '60-40', '40-60', '70-30', '30-70'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sectionRatioOptions'],
    'eval' => [
        'chosen' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(16) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sectionAlign'] = [
    'exclude' => true,
    'default' => 'start',
    'inputType' => 'select',
    'options' => ['start', 'center'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sectionAlignOptions'],
    'eval' => [
        'chosen' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(16) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sectionDivider'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sectionStackMobile'] = [
    'exclude' => true,
    'default' => '1',
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];
