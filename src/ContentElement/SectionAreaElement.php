<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\ContentElement;

use Contao\ContentElement;

class SectionAreaElement extends ContentElement
{
    protected $strTemplate = 'ce_vtxm_section_area';

    protected function compile(): void
    {
        $this->Template->isSplit = 'split' === SectionStartElement::getCurrentSectionType();
    }
}
