<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Tests\Section;

use PHPUnit\Framework\TestCase;
use Vendor\SectionElementsBundle\Section\SectionFields;
use Vendor\SectionElementsBundle\Section\SectionSequenceAnalyzer;

final class SectionSequenceAnalyzerTest extends TestCase
{
    public function testMultipleSequentialGridAndSplitSectionsAreIndependent(): void
    {
        $contexts = $this->analyze([
            $this->row(1, SectionFields::TYPE_START, [SectionFields::SECTION_TYPE => 'grid']),
            $this->row(2, 'text'),
            $this->row(3, SectionFields::TYPE_END),
            $this->row(4, SectionFields::TYPE_START, [SectionFields::SECTION_TYPE => 'split']),
            $this->row(5, SectionFields::TYPE_AREA),
            $this->row(6, SectionFields::TYPE_END),
        ]);

        self::assertTrue($contexts[1]->shouldRender());
        self::assertSame('grid', $contexts[1]->getSectionType());
        self::assertTrue($contexts[3]->shouldRender());
        self::assertSame('grid', $contexts[3]->getSectionType());
        self::assertTrue($contexts[4]->shouldRender());
        self::assertSame('split', $contexts[4]->getSectionType());
        self::assertTrue($contexts[5]->shouldRender());
        self::assertTrue($contexts[6]->shouldRender());
        self::assertSame('split', $contexts[6]->getSectionType());
    }

    public function testAreaAndEndWithoutMatchingStartAreInert(): void
    {
        $contexts = $this->analyze([
            $this->row(1, SectionFields::TYPE_AREA),
            $this->row(2, SectionFields::TYPE_END),
        ]);

        self::assertFalse($contexts[1]->shouldRender());
        self::assertSame('missing_start', $contexts[1]->getReason());
        self::assertFalse($contexts[2]->shouldRender());
        self::assertSame('missing_start', $contexts[2]->getReason());
    }

    public function testStartAndAreaBecomeInertWhenEndIsMissing(): void
    {
        $contexts = $this->analyze([
            $this->row(1, SectionFields::TYPE_START, [SectionFields::SECTION_TYPE => 'split']),
            $this->row(2, SectionFields::TYPE_AREA),
            $this->row(3, 'text'),
        ]);

        self::assertFalse($contexts[1]->shouldRender());
        self::assertSame('missing_end', $contexts[1]->getReason());
        self::assertFalse($contexts[2]->shouldRender());
        self::assertSame('missing_end', $contexts[2]->getReason());
    }

    public function testMalformedNestedStartDoesNotOpenAnotherSection(): void
    {
        $contexts = $this->analyze([
            $this->row(1, SectionFields::TYPE_START, [SectionFields::SECTION_TYPE => 'grid']),
            $this->row(2, SectionFields::TYPE_START, [SectionFields::SECTION_TYPE => 'split']),
            $this->row(3, SectionFields::TYPE_END),
            $this->row(4, SectionFields::TYPE_END),
        ]);

        self::assertTrue($contexts[1]->shouldRender());
        self::assertFalse($contexts[2]->shouldRender());
        self::assertSame('nested_start', $contexts[2]->getReason());
        self::assertTrue($contexts[3]->shouldRender());
        self::assertSame('grid', $contexts[3]->getSectionType());
        self::assertFalse($contexts[4]->shouldRender());
    }

    public function testSkippedInvisibleStructuralElementBreaksThePairDeterministically(): void
    {
        $contexts = $this->analyze([
            $this->row(2, SectionFields::TYPE_AREA),
            $this->row(3, SectionFields::TYPE_END),
        ]);

        self::assertFalse($contexts[2]->shouldRender());
        self::assertFalse($contexts[3]->shouldRender());
    }

    public function testRepeatedRenderingInOneRequestDoesNotShareState(): void
    {
        $rows = [
            $this->row(1, SectionFields::TYPE_START, [SectionFields::SECTION_TYPE => 'grid']),
            $this->row(2, SectionFields::TYPE_END),
        ];

        $first = $this->analyze($rows);
        $second = $this->analyze($rows);

        self::assertTrue($first[1]->shouldRender());
        self::assertTrue($second[1]->shouldRender());
        self::assertTrue($first[2]->shouldRender());
        self::assertTrue($second[2]->shouldRender());
    }

    public function testSeparateArticlesRenderedInOneRequestDoNotShareState(): void
    {
        $articleA = $this->analyze([
            $this->row(1, SectionFields::TYPE_START, [SectionFields::SECTION_TYPE => 'grid']),
            $this->row(2, SectionFields::TYPE_END),
        ]);
        $articleB = $this->analyze([
            $this->row(10, SectionFields::TYPE_END),
        ]);

        self::assertTrue($articleA[1]->shouldRender());
        self::assertTrue($articleA[2]->shouldRender());
        self::assertFalse($articleB[10]->shouldRender());
    }

    public function testLegacySectionTypeIsUsedWhenNewFieldIsAbsent(): void
    {
        $contexts = $this->analyze([
            $this->row(1, SectionFields::TYPE_START, [SectionFields::LEGACY_SECTION_TYPE => 'split']),
            $this->row(2, SectionFields::TYPE_AREA),
            $this->row(3, SectionFields::TYPE_END),
        ]);

        self::assertSame('split', $contexts[1]->getSectionType());
        self::assertTrue($contexts[2]->shouldRender());
        self::assertSame('split', $contexts[3]->getSectionType());
    }

    /**
     * @param list<array<string,mixed>> $rows
     *
     * @return array<int,\Vendor\SectionElementsBundle\Section\SectionRenderContext>
     */
    private function analyze(array $rows): array
    {
        return (new SectionSequenceAnalyzer())->analyze($rows);
    }

    /**
     * @param array<string,mixed> $extra
     *
     * @return array<string,mixed>
     */
    private function row(int $id, string $type, array $extra = []): array
    {
        return \array_merge(['id' => $id, 'type' => $type], $extra);
    }
}
