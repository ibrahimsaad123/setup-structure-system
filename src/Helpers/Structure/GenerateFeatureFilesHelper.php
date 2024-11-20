<?php

namespace Saad\SetupStructureSystem\Helpers\Structure;

use Illuminate\Support\Facades\Artisan;

class GenerateFeatureFilesHelper
{
    public static function generateFiles(string $featureName)
    {
        Artisan::call("make:model {$featureName} -m");

        Artisan::call("make:controller {$featureName}/{$featureName}Controller");

        Artisan::call("make:resource {$featureName}/{$featureName}Resource");

        Artisan::call("make:request {$featureName}/{$featureName}Request");

 
        Artisan::call("make:observer {$featureName}/{$featureName}Observer --model={$featureName}");
    }

    
}