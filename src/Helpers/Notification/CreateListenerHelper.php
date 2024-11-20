<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;

class CreateListenerHelper
{
    public static function createListener($featureName)
    {
        $listenerTemplate = "<?php\n\nnamespace App\Listeners\\$featureName;\n\nuse App\Events\\{$featureName}\\{$featureName}Event;\n\nclass {$featureName}Listener\n{\n    public function handle({$featureName}Event \$event)\n    {\n        // Handle event\n    }\n}\n";
        File::put(app_path("Listeners/{$featureName}/{$featureName}Listener.php"), $listenerTemplate);
    }
}