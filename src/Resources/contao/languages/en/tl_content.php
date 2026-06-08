<?php

$GLOBALS['TL_LANG']['CTE']['vtxm'] = ['VTXM', 'VTXM content elements'];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_start'] = [
    'VTXM Section Start',
    'Opens an inline section. Must be closed with VTXM Section End. Wrong nesting can break the frontend layout.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_area'] = [
    'VTXM Section Area Switch',
    'Switches split sections from area A to area B. Use only inside split sections. Wrong nesting can break the frontend layout.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_end'] = [
    'VTXM Section End',
    'Closes the currently opened inline section. Every Section Start must be closed with Section End. Wrong nesting can break the frontend layout.',
];

$GLOBALS['TL_LANG']['tl_content']['section_legend'] = 'Section settings';
$GLOBALS['TL_LANG']['tl_content']['grid_legend'] = 'Grid settings';
$GLOBALS['TL_LANG']['tl_content']['split_legend'] = 'Split settings';

$GLOBALS['TL_LANG']['tl_content']['sectionType'] = ['Section type', 'Choose whether the section is rendered as a grid or split layout.'];
$GLOBALS['TL_LANG']['tl_content']['sectionPreset'] = ['Preset', 'Choose an optional preset class for project-specific styling.'];
$GLOBALS['TL_LANG']['tl_content']['sectionColumns'] = ['Columns', 'Number of grid columns.'];
$GLOBALS['TL_LANG']['tl_content']['sectionGap'] = ['Gap', 'Spacing between grid elements.'];
$GLOBALS['TL_LANG']['tl_content']['sectionGridAlign'] = ['Grid alignment', 'Alignment of grid elements.'];
$GLOBALS['TL_LANG']['tl_content']['sectionRatio'] = ['Split ratio', 'Width ratio of the split areas.'];
$GLOBALS['TL_LANG']['tl_content']['sectionAlign'] = ['Split alignment', 'Vertical alignment of split areas.'];
$GLOBALS['TL_LANG']['tl_content']['sectionDivider'] = ['Show divider', 'Shows a divider line between the split areas.'];
$GLOBALS['TL_LANG']['tl_content']['sectionStackMobile'] = ['Stack on mobile', 'Stacks the areas below each other on smaller screens.'];

$GLOBALS['TL_LANG']['tl_content']['sectionTypeOptions'] = [
    'grid' => 'Grid',
    'split' => 'Split',
];

$GLOBALS['TL_LANG']['tl_content']['sectionPresetOptions'] = [
    'default' => 'Default',
    'about' => 'About',
    'contact' => 'Contact',
    'spotlight' => 'Spotlight',
];

$GLOBALS['TL_LANG']['tl_content']['sectionColumnsOptions'] = [
    '2' => '2 columns',
    '3' => '3 columns',
    '4' => '4 columns',
];

$GLOBALS['TL_LANG']['tl_content']['sectionGapOptions'] = [
    'small' => 'Small',
    'medium' => 'Medium',
    'large' => 'Large',
];

$GLOBALS['TL_LANG']['tl_content']['sectionGridAlignOptions'] = [
    'start' => 'Start',
    'center' => 'Center',
    'stretch' => 'Stretch',
];

$GLOBALS['TL_LANG']['tl_content']['sectionRatioOptions'] = [
    '50-50' => '50-50',
    '60-40' => '60-40',
    '40-60' => '40-60',
    '70-30' => '70-30',
    '30-70' => '30-70',
];

$GLOBALS['TL_LANG']['tl_content']['sectionAlignOptions'] = [
    'start' => 'Start',
    'center' => 'Center',
];
