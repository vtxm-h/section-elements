<?php

use Vendor\SectionElementsBundle\ContentElement\SectionAreaElement;
use Vendor\SectionElementsBundle\ContentElement\SectionEndElement;
use Vendor\SectionElementsBundle\ContentElement\SectionStartElement;

$GLOBALS['TL_CTE']['vtxm']['vtxm_section_start'] = SectionStartElement::class;
$GLOBALS['TL_CTE']['vtxm']['vtxm_section_area'] = SectionAreaElement::class;
$GLOBALS['TL_CTE']['vtxm']['vtxm_section_end'] = SectionEndElement::class;
