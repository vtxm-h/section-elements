<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Section;

final class SectionSequenceAnalyzer
{
    /**
     * @param list<array<string,mixed>> $rows Renderable sibling rows in frontend sorting order.
     *
     * @return array<int,SectionRenderContext>
     */
    public function analyze(array $rows): array
    {
        $contexts = [];
        $active = null;

        foreach ($rows as $row) {
            $id = (int) ($row['id'] ?? 0);
            $type = (string) ($row['type'] ?? '');

            if ($id < 1 || !SectionFields::isStructuralType($type)) {
                continue;
            }

            if (SectionFields::TYPE_START === $type) {
                if (null !== $active) {
                    $contexts[$id] = SectionRenderContext::invalid('start', 'nested_start');
                    continue;
                }

                $sectionType = SectionFields::sectionType($row);
                $active = [
                    'startId' => $id,
                    'sectionType' => $sectionType,
                    'areaIds' => [],
                    'hasArea' => false,
                ];

                $contexts[$id] = SectionRenderContext::start($sectionType);
                continue;
            }

            if (SectionFields::TYPE_AREA === $type) {
                if (
                    null !== $active
                    && 'split' === $active['sectionType']
                    && false === $active['hasArea']
                ) {
                    $contexts[$id] = SectionRenderContext::area();
                    $active['areaIds'][] = $id;
                    $active['hasArea'] = true;
                    continue;
                }

                $contexts[$id] = SectionRenderContext::invalid('area', null === $active ? 'missing_start' : 'invalid_area');
                continue;
            }

            if (SectionFields::TYPE_END === $type) {
                if (null === $active) {
                    $contexts[$id] = SectionRenderContext::invalid('end', 'missing_start');
                    continue;
                }

                $contexts[$id] = SectionRenderContext::end((string) $active['sectionType']);
                $active = null;
            }
        }

        if (null !== $active) {
            $contexts[(int) $active['startId']] = SectionRenderContext::invalid('start', 'missing_end');

            foreach ($active['areaIds'] as $areaId) {
                $contexts[(int) $areaId] = SectionRenderContext::invalid('area', 'missing_end');
            }
        }

        return $contexts;
    }
}
