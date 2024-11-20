<?php
namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;

class CreateNotificationControllerHelper
{
public static function createNotificationController()
{
if (!File::exists(app_path('Http/Controllers/NotificationController.php'))) {
$notificationControllerTemplate = "<?php\n\nnamespace App\Http\Controllers;\n\nuse App\Services\NotificationService;\n\nclass NotificationController extends Controller\n{\n    function __construct(public readonly NotificationService \$service)\n    {\n    }\n\n    public function index()\n    {\n        // Modify to fetch the user based on your project's implementation\n        return response()->json(\$this->service->index());\n    }\n\n    public function unreadCount()\n    {\n        // Modify to fetch the user based on your project's implementation\n        return response()->json(\$this->service->unreadCount());\n    }\n}\n";
            File::put(app_path('Http/Controllers/NotificationController.php'), $notificationControllerTemplate);
        }

        self::updateBaseController();
    }

    private static function updateBaseController()
    {
        $controllerPath = app_path('Http/Controllers/Controller.php');

        if (File::exists($controllerPath)) {
            $controllerContent = File::get($controllerPath);

            // Check if Controller already uses the traits or needs to be updated
            if (!str_contains($controllerContent, 'use HasApiResponse;') || !str_contains($controllerContent, 'use AuthorizesRequests;')) {
                $updatedContent = self::getUpdatedBaseControllerContent($controllerContent);
                File::put($controllerPath, $updatedContent);
            }
        }
    }

    private static function getUpdatedBaseControllerContent($controllerContent)
    {
        // Import traits at the top of the file
        $traitsImport = "use Illuminate\Foundation\Auth\Access\AuthorizesRequests;\nuse Illuminate\Foundation\Validation\ValidatesRequests;\nuse App\Traits\HasApiResponse;";
        $traitsUsage = "use AuthorizesRequests, ValidatesRequests, HasApiResponse;";

        // Check if the abstract class declaration exists
        if (str_contains($controllerContent, 'abstract class Controller')) {
            // Add trait imports if missing
            if (!str_contains($controllerContent, 'AuthorizesRequests') || !str_contains($controllerContent, 'ValidatesRequests') || !str_contains($controllerContent, 'HasApiResponse')) {
                $controllerContent = preg_replace(
                    '/namespace App\\\Http\\\Controllers;([\s\S]*?)(class|abstract class Controller)/',
                    "namespace App\\Http\\Controllers;\n\n$traitsImport\n\n$2",
                    $controllerContent
                );
            }

            // Add trait usage to the class definition if not already present
            if (!str_contains($controllerContent, 'use AuthorizesRequests')) {
                $controllerContent = preg_replace(
                    '/abstract class Controller\s*{/',
                    "abstract class Controller\n{\n    $traitsUsage",
                    $controllerContent
                );
            }
        }

        return $controllerContent;
    }
}