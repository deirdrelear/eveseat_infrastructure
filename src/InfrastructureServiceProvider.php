<?php


namespace Brutusv\Seat\infrastructure;


use Seat\Services\AbstractSeatPlugin;

class InfrastructureServiceProvider extends AbstractSeatPlugin
{

    public function getName(): string
    {
        return "Infrastructure";
    }

    public function getPackageRepositoryUrl(): string
    {
        return "infrastructure";
    }

    public function getPackagistPackageName(): string
    {
        return "infrastructure";
    }

    public function getPackagistVendorName(): string
    {
        return "brutusv";
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/infrastructure.sidebar.php','package.sidebar');
        $this->registerPermissions(__DIR__ . '/Config/Permissions/infrastructure.php', 'infrastructure');
    }

    public function boot()
    {
        $this->add_routes();
        $this->add_views();
        //$this->add_translations();
    }

    private function add_routes()
    {
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
    }

    private function add_views()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'infrastructure');
    }

    private function add_translations()
    {
        //$this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'infrastructure');
    }
}