<?php

$GLOBALS['TL_LANG']['CTE']['vtxm'] = ['VTXM', 'VTXM content elements'];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_start'] = [
    'VTXM Section Start',
    'Opens an inline section when a matching visible Section End exists later in the same content sequence.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_area'] = [
    'VTXM Section Area Switch',
    'Switches a matched split section from area A to area B. Use only once inside split sections.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_end'] = [
    'VTXM Section End',
    'Closes a matched inline section. Outputs nothing without a matching visible Section Start.',
];

$GLOBALS['TL_LANG']['tl_content']['vtxm_section_legend'] = 'Section settings';
$GLOBALS['TL_LANG']['tl_content']['vtxm_section_grid_legend'] = 'Grid settings';
$GLOBALS['TL_LANG']['tl_content']['vtxm_section_split_legend'] = 'Split settings';

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionType'] = ['Section type', 'Choose whether the section is rendered as a grid or split layout.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionPreset'] = ['Preset', 'Choose an optional styling preset for this section.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionColumns'] = ['Columns', 'Number of grid columns.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGap'] = ['Gap', 'Spacing between grid elements.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGridAlign'] = ['Grid alignment', 'Alignment of grid elements.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionRatio'] = ['Split ratio', 'Width ratio of the split areas.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionAlign'] = ['Split alignment', 'Vertical alignment of split areas.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionDivider'] = ['Show divider', 'Shows a divider line between the split areas.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionStackMobile'] = ['Stack on mobile', 'Stacks the areas below each other on smaller screens.'];

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionTypeOptions'] = [
    'grid' => 'Grid',
    'split' => 'Split',
];

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionPresetOptions'] = [
    'default' => 'Default',
    'about' => 'About',
    'contact' => 'Contact',
    'spotlight' => 'Spotlight',
];

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionColumnsOptions'] = [
    '2' => '2 columns',
    '3' => '3 columns',
    '4' => '4 columns',
];

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGapOptions'] = [
    'small' => 'Small',
    'medium' => 'Medium',
    'large' => 'Large',
];

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGridAlignOptions'] = [
    'start' => 'Start',
    'center' => 'Center',
    'stretch' => 'Stretch',
];

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionRatioOptions'] = [
    '50-50' => '50-50',
    '60-40' => '60-40',
    '40-60' => '40-60',
    '70-30' => '70-30',
    '30-70' => '30-70',
];

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionAlignOptions'] = [
    'start' => 'Start',
    'center' => 'Center',
];
