<?php

namespace Saad\SetupStructureSystem\Helpers\Structure;

use Illuminate\Support\Facades\File;

class CreateServiceHelper
{
    public static function createService(string $featureName)
    {
        $servicePath = app_path("Services/{$featureName}/{$featureName}Service.php");
        $serviceTemplate = "<?php

namespace App\Services\\{$featureName};

class {$featureName}Service
{
    // Service logic for {$featureName} feature
}";

        if (!file_exists(dirname($servicePath))) {
            mkdir(dirname($servicePath), 0777, true);
        }
        
        file_put_contents($servicePath, $serviceTemplate);
    }
}