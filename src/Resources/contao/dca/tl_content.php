<?php

use Vendor\SectionElementsBundle\Section\SectionDcaConfigurator;

(new SectionDcaConfigurator())->apply($GLOBALS['TL_DCA']['tl_content']);
