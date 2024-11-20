<?php

namespace Saad\SetupStructureSystem\Helpers\Structure;

use Illuminate\Support\Facades\File;

class CreateFeatureDirectoriesHelper
{
    public static function createFeatureDirectories($featureName)
    {
        File::ensureDirectoryExists(app_path("Http/Controllers/{$featureName}"));

        File::ensureDirectoryExists(app_path("Http/Resources/{$featureName}"));

        File::ensureDirectoryExists(app_path("Http/Requests/{$featureName}"));

        File::ensureDirectoryExists(app_path("Services/{$featureName}"));

        File::ensureDirectoryExists(app_path("Repositories/{$featureName}"));

        File::ensureDirectoryExists(app_path("Observers/{$featureName}"));

        File::ensureDirectoryExists(app_path("Models"));

        File::ensureDirectoryExists(database_path("migrations"));
    }
}