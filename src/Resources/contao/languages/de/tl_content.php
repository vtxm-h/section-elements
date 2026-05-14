<?php

$GLOBALS['TL_LANG']['CTE']['vtxm'] = ['VTXM', 'VTXM Inhaltselemente'];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_start'] = [
    'VTXM Section Start',
    'Öffnet eine Inline-Section. Muss mit VTXM Section Ende geschlossen werden. Falsche Verschachtelung kann das Frontend-Layout brechen.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_area'] = [
    'VTXM Section Bereich wechseln',
    'Wechselt in Split-Sections von Bereich A zu Bereich B. Nur innerhalb von Split-Sections verwenden. Falsche Verschachtelung kann das Frontend-Layout brechen.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_end'] = [
    'VTXM Section Ende',
    'Schließt die aktuell geöffnete Inline-Section. Jede Section Start muss mit Section Ende geschlossen werden. Falsche Verschachtelung kann das Frontend-Layout brechen.',
];

$GLOBALS['TL_LANG']['tl_content']['section_legend'] = 'Section-Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['grid_legend'] = 'Grid-Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['split_legend'] = 'Split-Einstellungen';

$GLOBALS['TL_LANG']['tl_content']['sectionType'] = ['Section-Typ', 'Wählen Sie, ob die Section als Grid oder Split-Layout ausgegeben wird.'];
$GLOBALS['TL_LANG']['tl_content']['sectionPreset'] = ['Preset', 'Wählen Sie eine optionale Preset-Klasse für projektspezifisches Styling.'];
$GLOBALS['TL_LANG']['tl_content']['sectionColumns'] = ['Spalten', 'Anzahl der Grid-Spalten. Wird für den Section-Typ Grid verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionGap'] = ['Abstand', 'Grid-Abstand zwischen den Elementen. Wird für den Section-Typ Grid verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionGridAlign'] = ['Grid-Ausrichtung', 'Ausrichtung der Grid-Elemente. Wird für den Section-Typ Grid verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionRatio'] = ['Split-Verhältnis', 'Breitenverhältnis der Split-Bereiche. Wird für den Section-Typ Split verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionAlign'] = ['Split-Ausrichtung', 'Vertikale Ausrichtung der Split-Bereiche. Wird für den Section-Typ Split verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionDivider'] = ['Trenner anzeigen', 'Fügt die Klasse has-divider hinzu. Wird für den Section-Typ Split verwendet.'];
$GLOBALS['TL_LANG']['tl_content']['sectionStackMobile'] = ['Mobil stapeln', 'Fügt die Klasse is-stack-mobile hinzu.'];

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
    'large' => 'Groß',
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
