<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Vendor\SectionElementsBundle\Migration\LegacySectionFieldsMigration;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->set(LegacySectionFieldsMigration::class)
        ->tag('contao.migration');
};
