<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;

class CreateNotificationServiceHelper
{
    public static function createNotificationService()
    {
        if (File::exists(app_path('Services/NotificationService.php'))) {
            return;
        }

        $serviceTemplate = self::getNotificationServiceTemplate();
        File::ensureDirectoryExists(app_path('Services'));
        File::put(app_path('Services/NotificationService.php'), $serviceTemplate);
    }

    private static function getNotificationServiceTemplate(): string
    {
        return <<<'SERVICE'
<?php

namespace App\Services;

use App\Models\User;
use App\Http\Resources\Notification\NotificationResource;

class NotificationService
{
    /**
     * Retrieve notifications for a user with optional filters.
     */
    public function index(User $user, array $filters = [])
    {
        $query = $user->notifications();

        if (isset($filters['unread'])) {
            $query->wherePivot('is_read', false);
        }

        if (isset($filters['from_date'])) {
            $query->where('created_at', '>=', $filters['from_date']);
        }

        $notifications = $query->get();

        return NotificationResource::collection($notifications);
    }

    /**
     * Get count of unread notifications for a user.
     */
    public function unreadCount(User $user): array
    {
        $count = $user->notifications()->wherePivot('is_read', false)->count();

        return [
            'count' => $count,
        ];
    }
}
SERVICE;
    }
}