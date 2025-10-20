<?php
namespace Deirdrelear\Seat\Infrastructure;

use Seat\Services\AbstractSeatPlugin;

class InfrastructureServiceProvider extends AbstractSeatPlugin
{
    public function getName(): string
    {
        return 'Infrastructure';
    }

    public function getPackagistVendorName(): string
    {
        return 'deirdrelear';
    }

    public function getPackagistPackageName(): string
    {
        return 'eveseat_infrastructure';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/deirdrelear/eveseat_infrastructure';
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/infrastructure.sidebar.php', 'package.sidebar');
        $this->registerPermissions(__DIR__ . '/Config/Permissions/infrastructure.php', 'infrastructure');
    }

    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        }

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'infrastructure');

        $this->publishes([
            __DIR__ . '/resources/js' => public_path('vendor/infrastructure/js'),
        ], 'infrastructure-public');
    }
}
