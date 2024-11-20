<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;

class CreateEventHelper
{
    public static function createEvent($featureName)
    {
        $eventTemplate = "<?php\n\nnamespace App\Events\\$featureName;\n\nuse Illuminate\Foundation\Events\Dispatchable;\n\nclass {$featureName}Event\n{\n    use Dispatchable;\n\n    public function __construct()\n    {\n        // Constructor\n    }\n}\n";
        File::put(app_path("Events/{$featureName}/{$featureName}Event.php"), $eventTemplate);
    }
}