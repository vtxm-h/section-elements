<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\ContentElement;

use Contao\ContentElement;
use Contao\StringUtil;

class SectionStartElement extends ContentElement
{
    protected $strTemplate = 'ce_vtxm_section_start';

    private const SECTION_TYPES = ['grid', 'split'];
    private const PRESETS = ['default', 'about', 'contact', 'spotlight'];
    private const COLUMNS = ['2', '3', '4'];
    private const GAPS = ['small', 'medium', 'large'];
    private const GRID_ALIGNMENTS = ['start', 'center', 'stretch'];
    private const RATIOS = ['50-50', '60-40', '40-60', '70-30', '30-70'];
    private const ALIGNMENTS = ['start', 'center'];
    private const HEADLINE_UNITS = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

    /**
     * @var list<string>
     */
    private static array $sectionStack = [];

    public static function getCurrentSectionType(): ?string
    {
        if ([] === self::$sectionStack) {
            return null;
        }

        return self::$sectionStack[\count(self::$sectionStack) - 1];
    }

    public static function closeCurrentSectionType(): ?string
    {
        return \array_pop(self::$sectionStack);
    }

    protected function compile(): void
    {
        $sectionType = $this->normalizeOption((string) ($this->sectionType ?: 'grid'), self::SECTION_TYPES, 'grid');
        $sectionPreset = $this->normalizeOption((string) ($this->sectionPreset ?: 'default'), self::PRESETS, 'default');
        $stackMobile = $this->normalizeCheckbox((string) $this->sectionStackMobile, true);

        self::$sectionStack[] = $sectionType;

        [$elementId, $extraClasses] = $this->getCssIdParts();

        $classes = [
            'ce_vtxm_section_start',
            'vtxm-section',
            'section--'.$sectionType,
            'preset--'.$sectionPreset,
        ];

        if ('grid' === $sectionType) {
            $columns = $this->normalizeOption((string) ($this->sectionColumns ?: '3'), self::COLUMNS, '3');
            $gap = $this->normalizeOption((string) ($this->sectionGap ?: 'medium'), self::GAPS, 'medium');
            $gridAlign = $this->normalizeOption((string) ($this->sectionGridAlign ?: 'stretch'), self::GRID_ALIGNMENTS, 'stretch');

            $classes[] = 'cg--cols-'.$columns;
            $classes[] = 'cg--gap-'.$gap;
            $classes[] = 'cg--align-'.$gridAlign;
        }

        if ('split' === $sectionType) {
            $ratio = $this->normalizeOption((string) ($this->sectionRatio ?: '50-50'), self::RATIOS, '50-50');
            $align = $this->normalizeOption((string) ($this->sectionAlign ?: 'start'), self::ALIGNMENTS, 'start');

            $classes[] = 'ratio--'.$ratio;
            $classes[] = 'align--'.$align;

            if ($this->normalizeCheckbox((string) $this->sectionDivider, false)) {
                $classes[] = 'has-divider';
            }
        }

        if ($stackMobile) {
            $classes[] = 'is-stack-mobile';
        }

        $classes = \array_merge($classes, $extraClasses);

        $this->setHeadlineTemplateOptions();

        $this->Template->elementId = StringUtil::specialchars($elementId);
        $this->Template->elementClass = StringUtil::specialchars(\implode(' ', \array_filter($classes)));
        $this->Template->sectionType = $sectionType;
    }

    /**
     * @return array{0: string, 1: list<string>}
     */
    private function getCssIdParts(): array
    {
        $cssId = $this->arrData['cssID'] ?? [];

        if (!\is_array($cssId)) {
            $cssId = StringUtil::deserialize($cssId, true);
        }

        $elementId = \trim((string) ($cssId[0] ?? ''));
        $classValue = \trim((string) ($cssId[1] ?? ''));
        $classes = [];

        if ('' !== $classValue) {
            $classes = \preg_split('/\s+/', $classValue) ?: [];
        }

        return [$elementId, \array_values(\array_filter($classes))];
    }

    private function setHeadlineTemplateOptions(): void
    {
        $headline = StringUtil::deserialize($this->headline, true);
        $headlineText = \trim((string) ($headline['value'] ?? ''));
        $headlineUnit = (string) ($headline['unit'] ?? 'h2');

        if (!\in_array($headlineUnit, self::HEADLINE_UNITS, true)) {
            $headlineUnit = 'h2';
        }

        $this->Template->headlineText = StringUtil::specialchars($headlineText);
        $this->Template->headlineUnit = $headlineUnit;
    }

    /**
     * @param list<string> $allowed
     */
    private function normalizeOption(string $value, array $allowed, string $default): string
    {
        return \in_array($value, $allowed, true) ? $value : $default;
    }

    private function normalizeCheckbox(string $value, bool $default): bool
    {
        if ('' === $value) {
            return $default;
        }

        return '1' === $value;
    }
}
