<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Tests\Section;

use PHPUnit\Framework\TestCase;
use Vendor\SectionElementsBundle\Section\SectionFields;

final class SectionFieldsTest extends TestCase
{
    public function testLegacyValuesAreUsedWhenNewFieldsAreAbsent(): void
    {
        self::assertSame(
            'split',
            SectionFields::option(
                [SectionFields::LEGACY_SECTION_TYPE => 'split'],
                SectionFields::SECTION_TYPE,
                SectionFields::SECTION_TYPES,
                SectionFields::DEFAULTS[SectionFields::SECTION_TYPE]
            )
        );

        self::assertTrue(
            SectionFields::checkbox(
                [SectionFields::LEGACY_SECTION_STACK_MOBILE => '1'],
                SectionFields::SECTION_STACK_MOBILE,
                false
            )
        );
    }

    public function testEmptyNewValuesDoNotFallBackToRemainingLegacyValues(): void
    {
        self::assertSame(
            SectionFields::DEFAULTS[SectionFields::SECTION_TYPE],
            SectionFields::option(
                [
                    SectionFields::SECTION_TYPE => '',
                    SectionFields::LEGACY_SECTION_TYPE => 'split',
                ],
                SectionFields::SECTION_TYPE,
                SectionFields::SECTION_TYPES,
                SectionFields::DEFAULTS[SectionFields::SECTION_TYPE]
            )
        );

        self::assertFalse(
            SectionFields::checkbox(
                [
                    SectionFields::SECTION_DIVIDER => '',
                    SectionFields::LEGACY_SECTION_DIVIDER => '1',
                ],
                SectionFields::SECTION_DIVIDER,
                false
            )
        );

        self::assertFalse(
            SectionFields::checkbox(
                [
                    SectionFields::SECTION_STACK_MOBILE => '',
                    SectionFields::LEGACY_SECTION_STACK_MOBILE => '1',
                ],
                SectionFields::SECTION_STACK_MOBILE,
                true
            )
        );
    }
}
