<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\ContentElement;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\StringUtil;
use Vendor\SectionElementsBundle\Section\SectionContextResolver;
use Vendor\SectionElementsBundle\Section\SectionFields;
use Vendor\SectionElementsBundle\Section\SectionRenderContext;

abstract class AbstractSectionElement extends ContentElement
{
    final public function generate()
    {
        if (\defined('TL_MODE') && 'BE' === TL_MODE) {
            return $this->generateBackendWildcard();
        }

        return parent::generate();
    }

    abstract protected function getBackendWildcardLabel(): string;

    /**
     * @return list<string>
     */
    protected function getBackendDetails(): array
    {
        return [];
    }

    protected function resolveSectionContext(): SectionRenderContext
    {
        return (new SectionContextResolver())->resolve($this->arrData);
    }

    /**
     * @param list<string> $allowed
     */
    protected function option(string $field, array $allowed, string $default): string
    {
        return SectionFields::option($this->arrData, $field, $allowed, $default);
    }

    protected function checkbox(string $field, bool $default): bool
    {
        return SectionFields::checkbox($this->arrData, $field, $default);
    }

    protected function escape(string $value): string
    {
        return StringUtil::specialchars($value);
    }

    /**
     * @return array{0: string, 1: list<string>}
     */
    protected function getCssIdParts(): array
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

    protected function setHeadlineTemplateOptions(): void
    {
        $headlineText = \trim((string) $this->headline);
        $headlineUnit = (string) ($this->hl ?: 'h2');

        if (!\in_array($headlineUnit, SectionFields::HEADLINE_UNITS, true)) {
            $headlineUnit = 'h2';
        }

        $this->Template->headlineText = $this->escape($headlineText);
        $this->Template->headlineUnit = $headlineUnit;
    }

    private function generateBackendWildcard(): string
    {
        $wildcard = '### '.$this->getBackendWildcardLabel().' ###';
        $details = $this->getBackendDetails();

        if ([] !== $details) {
            $wildcard .= '<br><small>'.$this->escape(\implode(' | ', $details)).'</small>';
        }

        $template = new BackendTemplate('be_wildcard');
        $template->wildcard = $wildcard;
        $template->title = $this->escape(\trim((string) $this->headline));
        $template->id = (int) ($this->arrData['id'] ?? 0);
        $template->link = $this->getBackendWildcardLabel();
        $template->href = '';

        return $template->parse();
    }
}
