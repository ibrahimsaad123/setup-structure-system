<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;

class CreateNotificationPolicyHelper
{
    public static function createNotificationPolicy()
    {
        $policyTemplate = self::getNotificationPolicyTemplate();
        File::ensureDirectoryExists(app_path('Policies'));
        File::put(app_path('Policies/NotificationPolicy.php'), $policyTemplate);

        self::updateAuthServiceProvider();
    }

    private static function getNotificationPolicyTemplate(): string
    {
        return <<<'POLICY'
<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

class NotificationPolicy
{
    public function view(User $user, Notification $notification)
    {
        return $notification->users->contains($user);
    }

    public function update(User $user, Notification $notification)
    {
        return $notification->users->contains($user);
    }
}
POLICY;
    }

    private static function updateAuthServiceProvider()
    {
        $providerPath = app_path('Providers/AuthServiceProvider.php');
        if (File::exists($providerPath)) {
            $content = File::get($providerPath);
            if (!str_contains($content, 'Notification::class => NotificationPolicy::class')) {
                $policyMapping = "\n\t\tApp\Models\Notification::class => App\Policies\NotificationPolicy::class,";
                $updatedContent = preg_replace('/protected \$policies = \[/', 'protected $policies = [' . $policyMapping, $content);
                File::put($providerPath, $updatedContent);
            }
        }
    }
}   