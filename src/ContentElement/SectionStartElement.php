<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\ContentElement;

use Vendor\SectionElementsBundle\Section\SectionFields;

class SectionStartElement extends AbstractSectionElement
{
    protected $strTemplate = 'ce_vtxm_section_start';

    protected function compile(): void
    {
        $context = $this->resolveSectionContext();
        $this->Template->shouldRender = $context->shouldRender();

        if (!$context->shouldRender()) {
            return;
        }

        $sectionType = $context->getSectionType();
        $sectionPreset = $this->option(SectionFields::SECTION_PRESET, SectionFields::PRESETS, SectionFields::DEFAULTS[SectionFields::SECTION_PRESET]);
        $stackMobile = $this->checkbox(SectionFields::SECTION_STACK_MOBILE, true);

        [$elementId, $extraClasses] = $this->getCssIdParts();

        $classes = [
            'ce_vtxm_section_start',
            'vtxm-section',
            'section--'.$sectionType,
            'preset--'.$sectionPreset,
        ];

        if ('grid' === $sectionType) {
            $columns = $this->option(SectionFields::SECTION_COLUMNS, SectionFields::COLUMNS, SectionFields::DEFAULTS[SectionFields::SECTION_COLUMNS]);
            $gap = $this->option(SectionFields::SECTION_GAP, SectionFields::GAPS, SectionFields::DEFAULTS[SectionFields::SECTION_GAP]);
            $gridAlign = $this->option(SectionFields::SECTION_GRID_ALIGN, SectionFields::GRID_ALIGNMENTS, SectionFields::DEFAULTS[SectionFields::SECTION_GRID_ALIGN]);

            $classes[] = 'cg--cols-'.$columns;
            $classes[] = 'cg--gap-'.$gap;
            $classes[] = 'cg--align-'.$gridAlign;
        }

        if ('split' === $sectionType) {
            $ratio = $this->option(SectionFields::SECTION_RATIO, SectionFields::RATIOS, SectionFields::DEFAULTS[SectionFields::SECTION_RATIO]);
            $align = $this->option(SectionFields::SECTION_ALIGN, SectionFields::ALIGNMENTS, SectionFields::DEFAULTS[SectionFields::SECTION_ALIGN]);

            $classes[] = 'ratio--'.$ratio;
            $classes[] = 'align--'.$align;

            if ($this->checkbox(SectionFields::SECTION_DIVIDER, false)) {
                $classes[] = 'has-divider';
            }
        }

        if ($stackMobile) {
            $classes[] = 'is-stack-mobile';
        }

        $classes = \array_merge($classes, $extraClasses);

        $this->setHeadlineTemplateOptions();

        $this->Template->elementId = $this->escape($elementId);
        $this->Template->elementClass = $this->escape(\implode(' ', \array_filter($classes)));
        $this->Template->sectionType = $sectionType;
    }

    /**
     * @return list<string>
     */
    protected function getBackendDetails(): array
    {
        $sectionType = SectionFields::sectionType($this->arrData);

        return [
            'type: '.$sectionType,
            'preset: '.$this->option(SectionFields::SECTION_PRESET, SectionFields::PRESETS, SectionFields::DEFAULTS[SectionFields::SECTION_PRESET]),
        ];
    }

    protected function getBackendWildcardLabel(): string
    {
        return 'VTXM Section Start';
    }
}
