<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\ContentElement;

class SectionAreaElement extends AbstractSectionElement
{
    protected $strTemplate = 'ce_vtxm_section_area';

    protected function compile(): void
    {
        $context = $this->resolveSectionContext();

        $this->Template->shouldRender = $context->shouldRender();
        $this->Template->isSplit = $context->shouldRender() && 'split' === $context->getSectionType();
    }

    protected function getBackendWildcardLabel(): string
    {
        return 'VTXM Section Area Switch';
    }
}
