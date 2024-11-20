<?php

namespace Saad\SetupStructureSystem\Providers;

use Illuminate\Support\ServiceProvider;
use Saad\SetupStructureSystem\Commands\SetupSystemStructure;
use Saad\SetupStructureSystem\Helpers\Notification\EnsureEventServiceProviderHelper;

class SetupStructureServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            SetupSystemStructure::class,
        ]);
    }

    public function boot()
    {
        $this->publishFiles();
        
        if (class_exists(EnsureEventServiceProviderHelper::class)) {
            EnsureEventServiceProviderHelper::ensureEventServiceProvider();
        }
    }

    protected function publishFiles()
    {
        $configPath = function_exists('config_path') ? config_path('setup-structure-system.php') : base_path('config/setup-structure-system.php');
        
        if (file_exists(__DIR__.'/../config/setup-structure-system.php')) {
            $this->publishes([
                __DIR__.'/../config/setup-structure-system.php' => $configPath,
            ], 'config');
        }
    }
}