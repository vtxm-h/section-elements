<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Section;

use Contao\ContentModel;
use Contao\Controller;
use Contao\Date;
use Contao\Model;
use Contao\System;

final class SectionContextResolver
{
    private SectionSequenceAnalyzer $analyzer;
    private SectionContentVisibility $visibility;

    public function __construct(?SectionSequenceAnalyzer $analyzer = null, ?SectionContentVisibility $visibility = null)
    {
        $this->analyzer = $analyzer ?? new SectionSequenceAnalyzer();
        $this->visibility = $visibility ?? new SectionContentVisibility();
    }

    /**
     * @param array<string,mixed> $currentRow
     */
    public function resolve(array $currentRow): SectionRenderContext
    {
        $currentId = (int) ($currentRow['id'] ?? 0);

        if ($currentId < 1 || !\class_exists(ContentModel::class)) {
            return SectionRenderContext::invalid((string) ($currentRow['type'] ?? ''), 'missing_model');
        }

        $contexts = $this->analyzer->analyze($this->loadRenderableSiblingRows($currentRow));

        return $contexts[$currentId] ?? SectionRenderContext::invalid((string) ($currentRow['type'] ?? ''), 'not_in_sequence');
    }

    /**
     * @param array<string,mixed> $currentRow
     *
     * @return list<array<string,mixed>>
     */
    private function loadRenderableSiblingRows(array $currentRow): array
    {
        $pid = (int) ($currentRow['pid'] ?? 0);
        $ptable = \trim((string) ($currentRow['ptable'] ?? ''));

        if ($pid < 1) {
            return [];
        }

        $table = 'tl_content';
        $parentTable = '' !== $ptable ? $ptable : 'tl_article';

        if ('tl_article' === $parentTable) {
            $columns = ["$table.pid=? AND ($table.ptable=? OR $table.ptable='')"];
        } else {
            $columns = ["$table.pid=? AND $table.ptable=?"];
        }

        $collection = ContentModel::findBy($columns, [$pid, $parentTable], ['order' => "$table.sorting"]);

        if (null === $collection) {
            return [];
        }

        $rows = [];
        $previewMode = $this->isPreviewMode();
        $time = $this->currentTime();

        if ($collection instanceof ContentModel) {
            $models = [$collection];
        } else {
            $models = [];

            while ($collection->next()) {
                $models[] = $collection->current();
            }
        }

        foreach ($models as $model) {
            $row = $model->row();

            if (!SectionFields::isStructuralType((string) ($row['type'] ?? ''))) {
                continue;
            }

            if (!$this->visibility->isRenderable($row, $previewMode, $time, $this->isFrontendAccessAllowed($model))) {
                continue;
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function isFrontendAccessAllowed(Model $model): bool
    {
        if (!\defined('TL_MODE') || 'FE' !== TL_MODE || !\class_exists(Controller::class)) {
            return true;
        }

        return Controller::isVisibleElement($model);
    }

    private function currentTime(): int
    {
        if (\class_exists(Date::class)) {
            return Date::floorToMinute();
        }

        return \time();
    }

    private function isPreviewMode(): bool
    {
        if (!\class_exists(System::class)) {
            return false;
        }

        $container = System::getContainer();

        return $container->has('contao.security.token_checker')
            && $container->get('contao.security.token_checker')->isPreviewMode();
    }
}
