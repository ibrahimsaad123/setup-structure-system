<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;


use Illuminate\Support\Facades\File;

class EnsureEventServiceProviderHelper
{
    public static function ensureEventServiceProvider()
    {
        $providerPath = function_exists('app_path') ? app_path('Providers/EventServiceProvider.php') : base_path('app/Providers/EventServiceProvider.php');

        if (!File::exists($providerPath)) {
            self::createEventServiceProvider($providerPath);
        }
    }

    public static function createEventServiceProvider($providerPath)
    {
        $providerContent = <<<'PROVIDER'
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // 'App\Events\SomeEvent' => [
        //     'App\Listeners\SomeListener',
        // ],
    ];

    public function boot(): void
    {
        //
    }
}
PROVIDER;

        File::ensureDirectoryExists(dirname($providerPath));
        File::put($providerPath, $providerContent);
    }

    public static function updateEventServiceProvider(string $featureName)
    {
        $providerPath = function_exists('app_path') ? app_path('Providers/EventServiceProvider.php') : base_path('app/Providers/EventServiceProvider.php');

        if (File::exists($providerPath)) {
            $content = File::get($providerPath);
            $eventListenerBinding = "\n        'App\Events\\$featureName\\{$featureName}Event' => [\n            'App\Listeners\\$featureName\\{$featureName}Listener',\n        ],";

            if (!str_contains($content, $eventListenerBinding)) {
                $content = str_replace("protected \$listen = [", "protected \$listen = [" . $eventListenerBinding, $content);
                File::put($providerPath, $content);
            }
        }
    }
}