<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Tests\ContentElement;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Vendor\SectionElementsBundle\ContentElement\AbstractSectionElement;
use Vendor\SectionElementsBundle\ContentElement\SectionAreaElement;
use Vendor\SectionElementsBundle\ContentElement\SectionEndElement;
use Vendor\SectionElementsBundle\ContentElement\SectionStartElement;

final class SectionElementStateTest extends TestCase
{
    public function testSectionElementsDeclareNoMutableStaticFrontendState(): void
    {
        foreach ([SectionStartElement::class, SectionAreaElement::class, SectionEndElement::class] as $class) {
            $reflection = new ReflectionClass($class);

            $declaredStaticProperties = \array_filter(
                $reflection->getProperties(ReflectionProperty::IS_STATIC),
                static fn (ReflectionProperty $property): bool => $property->getDeclaringClass()->getName() === $class
            );

            self::assertSame([], $declaredStaticProperties);
        }
    }

    public function testBackendRenderingIsHandledBeforeFrontendContextResolution(): void
    {
        $method = new ReflectionMethod(AbstractSectionElement::class, 'generate');

        self::assertTrue($method->isFinal());
        self::assertSame(AbstractSectionElement::class, $method->getDeclaringClass()->getName());
    }
}
