<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Tests\Section;

use PHPUnit\Framework\TestCase;
use Vendor\SectionElementsBundle\Section\SectionContentVisibility;

final class SectionContentVisibilityTest extends TestCase
{
    public function testInvisibleAndScheduledElementsAreSkippedOutsidePreview(): void
    {
        $visibility = new SectionContentVisibility();

        self::assertFalse($visibility->isRenderable(['id' => 1, 'invisible' => '1'], false, 100, true));
        self::assertFalse($visibility->isRenderable(['id' => 2, 'start' => 200], false, 100, true));
        self::assertFalse($visibility->isRenderable(['id' => 3, 'stop' => 100], false, 100, true));
        self::assertTrue($visibility->isRenderable(['id' => 4, 'stop' => 101], false, 100, true));
    }

    public function testPreviewKeepsHiddenPublishedElementsButNeverUnsavedOnes(): void
    {
        $visibility = new SectionContentVisibility();

        self::assertTrue($visibility->isRenderable(['id' => 1, 'invisible' => '1', 'tstamp' => '1'], true, 100, true));
        self::assertFalse($visibility->isRenderable(['id' => 2, 'invisible' => '', 'tstamp' => '0'], true, 100, true));
    }

    public function testProtectedOrGuestAccessDenialSkipsElement(): void
    {
        $visibility = new SectionContentVisibility();

        self::assertFalse($visibility->isRenderable(['id' => 1], false, 100, false));
    }
}
