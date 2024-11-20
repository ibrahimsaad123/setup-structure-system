<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;

class CreateNotificationEventInterfaceHelper
{
    public static function createNotificationEventInterface()
    {
        $interfaceTemplate = self::getNotificationEventInterfaceTemplate();
        File::ensureDirectoryExists(app_path('Interfaces'));
        File::put(app_path('Interfaces/NotificationEventInterface.php'), $interfaceTemplate);
    }

    private static function getNotificationEventInterfaceTemplate(): string
    {
        return <<<'INTERFACE'
<?php

namespace App\Interfaces;

interface NotificationEventInterface
{
    public function getTitle(): string;
    public function getBody(): string;
    public function getUserId(): int;
}
INTERFACE;
    }
}