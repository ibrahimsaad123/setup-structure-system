<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;

class CreateDirectoriesHelper
{
    public static function createDirectories($featureName)
    {
        File::ensureDirectoryExists(app_path("Events/{$featureName}"));
        File::ensureDirectoryExists(app_path("Listeners/{$featureName}"));
        File::ensureDirectoryExists(app_path('Helpers'));
        File::ensureDirectoryExists(app_path('Services'));
    }
}