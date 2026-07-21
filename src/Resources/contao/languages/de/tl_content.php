<?php

$GLOBALS['TL_LANG']['CTE']['vtxm'] = ['VTXM', 'VTXM Inhaltselemente'];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_start'] = [
    'VTXM Section Start',
    'Öffnet eine Inline-Section, wenn später in derselben Inhaltsfolge ein passendes sichtbares Section Ende existiert.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_area'] = [
    'VTXM Section Bereich wechseln',
    'Wechselt eine passende Split-Section von Bereich A zu Bereich B. Nur einmal innerhalb von Split-Sections verwenden.',
];

$GLOBALS['TL_LANG']['CTE']['vtxm_section_end'] = [
    'VTXM Section Ende',
    'Schließt eine passende Inline-Section. Gibt ohne passenden sichtbaren Section Start nichts aus.',
];

$GLOBALS['TL_LANG']['tl_content']['vtxm_section_legend'] = 'Section-Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['vtxm_section_grid_legend'] = 'Grid-Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['vtxm_section_split_legend'] = 'Split-Einstellungen';

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionType'] = ['Section-Typ', 'Wählen Sie, ob die Section als Grid oder Split-Layout ausgegeben wird.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionPreset'] = ['Preset', 'Wählen Sie eine optionale Gestaltungsvorgabe für diese Section.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionColumns'] = ['Spalten', 'Anzahl der Grid-Spalten.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGap'] = ['Abstand', 'Abstand zwischen den Grid-Elementen.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGridAlign'] = ['Grid-Ausrichtung', 'Ausrichtung der Grid-Elemente.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionRatio'] = ['Split-Verhältnis', 'Breitenverhältnis der Split-Bereiche.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionAlign'] = ['Split-Ausrichtung', 'Vertikale Ausrichtung der Split-Bereiche.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionDivider'] = ['Trenner anzeigen', 'Zeigt eine Trennlinie zwischen den Split-Bereichen an.'];
$GLOBALS['TL_LANG']['tl_content']['vtxmSectionStackMobile'] = ['Mobil stapeln', 'Stapelt die Bereiche auf kleineren Bildschirmen untereinander.'];

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
    '2' => '2 Spalten',
    '3' => '3 Spalten',
    '4' => '4 Spalten',
];

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGapOptions'] = [
    'small' => 'Klein',
    'medium' => 'Mittel',
    'large' => 'Groß',
];

$GLOBALS['TL_LANG']['tl_content']['vtxmSectionGridAlignOptions'] = [
    'start' => 'Start',
    'center' => 'Zentriert',
    'stretch' => 'Strecken',
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
    'center' => 'Zentriert',
];
