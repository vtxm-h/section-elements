<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Tests\Dca;

use PHPUnit\Framework\TestCase;
use Vendor\SectionElementsBundle\Section\SectionDcaConfigurator;
use Vendor\SectionElementsBundle\Section\SectionFields;

final class SectionDcaConfiguratorTest extends TestCase
{
    public function testSelectorCollisionIsAvoidedAndExistingSelectorsArePreserved(): void
    {
        $dca = [
            'palettes' => [
                '__selector__' => ['otherSelector', SectionFields::SECTION_TYPE, 'otherSelector'],
            ],
            'subpalettes' => [],
            'fields' => [],
        ];

        (new SectionDcaConfigurator())->apply($dca);

        self::assertSame(['otherSelector', SectionFields::SECTION_TYPE], $dca['palettes']['__selector__']);
    }

    public function testPreExistingSubpalettesArePreservedAndMergedWithoutDuplicates(): void
    {
        $dca = [
            'palettes' => [
                '__selector__' => [],
            ],
            'subpalettes' => [
                SectionFields::SECTION_TYPE.'_grid' => 'thirdPartyField,'.SectionFields::SECTION_GAP,
            ],
            'fields' => [],
        ];

        (new SectionDcaConfigurator())->apply($dca);

        self::assertSame(
            'thirdPartyField,'.SectionFields::SECTION_GAP.','.SectionFields::SECTION_COLUMNS.','.SectionFields::SECTION_GRID_ALIGN,
            $dca['subpalettes'][SectionFields::SECTION_TYPE.'_grid']
        );
    }

    public function testGenericLegacyFieldsAreNotRegisteredOrOverwritten(): void
    {
        $dca = [
            'palettes' => [
                '__selector__' => ['sectionType'],
            ],
            'subpalettes' => [
                'sectionType_grid' => 'foreignField',
            ],
            'fields' => [
                'sectionType' => ['label' => 'foreign'],
            ],
        ];

        (new SectionDcaConfigurator())->apply($dca);

        self::assertSame(['sectionType', SectionFields::SECTION_TYPE], $dca['palettes']['__selector__']);
        self::assertSame('foreignField', $dca['subpalettes']['sectionType_grid']);
        self::assertSame(['label' => 'foreign'], $dca['fields']['sectionType']);
        self::assertArrayHasKey(SectionFields::SECTION_TYPE, $dca['fields']);
    }
}
