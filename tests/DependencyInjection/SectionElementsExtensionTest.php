<?php

declare(strict_types=1);

namespace Vendor\SectionElementsBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Vendor\SectionElementsBundle\DependencyInjection\SectionElementsExtension;
use Vendor\SectionElementsBundle\Migration\LegacySectionFieldsMigration;

final class SectionElementsExtensionTest extends TestCase
{
    public function testMigrationServiceIsRegisteredWithContaoMigrationTag(): void
    {
        $container = new ContainerBuilder();

        (new SectionElementsExtension())->load([], $container);

        self::assertTrue($container->hasDefinition(LegacySectionFieldsMigration::class));
        self::assertNotSame([], $container->getDefinition(LegacySectionFieldsMigration::class)->getTag('contao.migration'));
    }
}
