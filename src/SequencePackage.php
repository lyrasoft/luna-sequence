<?php

/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2022 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Sequence;

use Lyrasoft\Sequence\Service\SequenceService;
use Windwalker\Core\Package\AbstractPackage;
use Windwalker\Core\Package\PackageInstaller;
use Windwalker\DI\Container;
use Windwalker\DI\ServiceProviderInterface;

/**
 * The SequencePackage class.
 */
class SequencePackage extends AbstractPackage implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $container): void
    {
        $container->prepareSharedObject(SequenceService::class);
    }

    public function install(PackageInstaller $installer): void
    {
        $installer->installMigrations(static::path('resources/migrations/**/*'), 'migrations');

        $installer->installModules(
            [
                static::path("src/Entity/Sequence.php") => '@source/Entity',
            ],
            [
                'Lyrasoft\\Sequence\\Entity' => 'App\\Entity',
            ],
            ['modules', 'model']
        );
    }
}
