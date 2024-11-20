<?php

namespace Saad\SetupStructureSystem\Helpers\Structure;

use Illuminate\Support\Facades\File;

class CreateRepositoryHelper
{
    public static function createRepository(string $featureName)
    {
        $repositoryPath = app_path("Repositories/{$featureName}/{$featureName}Repository.php");
        $repositoryTemplate = "<?php

namespace App\Repositories\\{$featureName};

class {$featureName}Repository
{
    // Repository logic for {$featureName} model
}";

        if (!file_exists(dirname($repositoryPath))) {
            mkdir(dirname($repositoryPath), 0777, true);
        }
        
        file_put_contents($repositoryPath, $repositoryTemplate);
    }
}