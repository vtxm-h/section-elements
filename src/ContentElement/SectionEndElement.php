<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\ContentElement;

use Contao\ContentElement;

class SectionEndElement extends ContentElement
{
    protected $strTemplate = 'ce_vtxm_section_end';

    protected function compile(): void
    {
        $this->Template->sectionType = SectionStartElement::closeCurrentSectionType() ?? '';
    }
}
