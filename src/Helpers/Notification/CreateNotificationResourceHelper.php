<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;

class CreateNotificationResourceHelper
{
    public static function createNotificationResource()
    {
        $resourceTemplate = self::getNotificationResourceTemplate();
        File::ensureDirectoryExists(app_path('Http/Resources/Notification'));
        File::put(app_path('Http/Resources/Notification/NotificationResource.php'), $resourceTemplate);
    }

    private static function getNotificationResourceTemplate(): string
    {
        return <<<'RESOURCE'
<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'reason' => $this->reason,
            'created_at' => $this->created_at,
            'is_read' => $this->pivot->is_read ?? null,
        ];
    }
}
RESOURCE;
    }
}