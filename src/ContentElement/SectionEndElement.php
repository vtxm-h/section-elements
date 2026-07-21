<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\ContentElement;

class SectionEndElement extends AbstractSectionElement
{
    protected $strTemplate = 'ce_vtxm_section_end';

    protected function compile(): void
    {
        $context = $this->resolveSectionContext();

        $this->Template->shouldRender = $context->shouldRender();
        $this->Template->sectionType = $context->shouldRender() ? $context->getSectionType() : '';
    }

    protected function getBackendWildcardLabel(): string
    {
        return 'VTXM Section End';
    }
}
