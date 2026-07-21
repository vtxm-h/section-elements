<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Section;

final class SectionContentVisibility
{
    /**
     * @param array<string,mixed> $row
     */
    public function isRenderable(array $row, bool $previewMode, int $time, bool $frontendAccessAllowed): bool
    {
        if (isset($row['tstamp']) && '0' === (string) $row['tstamp']) {
            return false;
        }

        if (!$frontendAccessAllowed) {
            return false;
        }

        if ($previewMode) {
            return true;
        }

        if ($this->isTruthy($row['invisible'] ?? '')) {
            return false;
        }

        $start = (int) ($row['start'] ?? 0);

        if ($start > 0 && $start > $time) {
            return false;
        }

        $stop = (int) ($row['stop'] ?? 0);

        return 0 === $stop || $stop > $time;
    }

    private function isTruthy(mixed $value): bool
    {
        return true === $value || 1 === $value || '1' === (string) $value;
    }
}
