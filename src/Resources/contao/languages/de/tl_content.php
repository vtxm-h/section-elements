<?php

$GLOBALS['TL_LANG']['CTE']['vtxm'] = ['VTXM', 'VTXM Inhaltselemente'];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_start'] = [
    'VTXM Section Start',
    'Oeffnet eine Inline-Section. Muss mit VTXM Section Ende geschlossen werden. Falsche Verschachtelung kann das Frontend-Layout brechen.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_area'] = [
    'VTXM Section Bereich wechseln',
    'Wechselt in Split-Sections von Bereich A zu Bereich B. Nur innerhalb von Split-Sections verwenden. Falsche Verschachtelung kann das Frontend-Layout brechen.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_end'] = [
    'VTXM Section Ende',
    'Schliesst die aktuell geoeffnete Inline-Section. Jede Section Start muss mit Section Ende geschlossen werden. Falsche Verschachtelung kann das Frontend-Layout brechen.',
];

$GLOBALS['TL_LANG']['tl_content']['section_legend'] = 'Section-Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['grid_legend'] = 'Grid-Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['split_legend'] = 'Split-Einstellungen';

$GLOBALS['TL_LANG']['tl_content']['sectionType'] = ['Section-Typ', 'Waehlen Sie, ob die Section als Grid oder Split-Layout ausgegeben wird.'];
$GLOBALS['TL_LANG']['tl_content']['sectionPreset'] = ['Preset', 'Waehlen Sie eine optionale Preset-Klasse fuer projektspezifisches Styling.'];
$GLOBALS['TL_LANG']['tl_content']['sectionColumns'] = ['Spalten', 'Anzahl der Grid-Spalten. Wird fuer den Section-Typ Grid verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionGap'] = ['Abstand', 'Grid-Abstand zwischen den Elementen. Wird fuer den Section-Typ Grid verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionGridAlign'] = ['Grid-Ausrichtung', 'Ausrichtung der Grid-Elemente. Wird fuer den Section-Typ Grid verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionRatio'] = ['Split-Verhaeltnis', 'Breitenverhaeltnis der Split-Bereiche. Wird fuer den Section-Typ Split verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionAlign'] = ['Split-Ausrichtung', 'Vertikale Ausrichtung der Split-Bereiche. Wird fuer den Section-Typ Split verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionDivider'] = ['Trenner anzeigen', 'Fuegt die Klasse has-divider hinzu. Wird fuer den Section-Typ Split verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionStackMobile'] = ['Mobil stapeln', 'Fuegt die Klasse is-stack-mobile hinzu.'];

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
    '2' => '2 Spalten',
    '3' => '3 Spalten',
    '4' => '4 Spalten',
];

$GLOBALS['TL_LANG']['tl_content']['sectionGapOptions'] = [
    'small' => 'Klein',
    'medium' => 'Mittel',
    'large' => 'Gross',
];

$GLOBALS['TL_LANG']['tl_content']['sectionGridAlignOptions'] = [
    'start' => 'Start',
    'center' => 'Zentriert',
    'stretch' => 'Strecken',
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
    'center' => 'Zentriert',
];
