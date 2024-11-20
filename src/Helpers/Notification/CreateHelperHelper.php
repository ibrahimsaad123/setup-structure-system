<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;

class CreateHelperHelper
{
    public static function createHelper()
    {
        $helperPath = app_path('Helpers/SendNotificationHelper.php');

        if (!File::exists($helperPath)) {
            $helperTemplate = "<?php

namespace App\Helpers;

use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class SendNotificationHelper
{
    private Messaging \$messaging;  

    public function __construct()
    {
        \$this->messaging = app('firebase.messaging');
    }

    public function sendMulticast(array \$deviceTokens, string \$title, string \$body): void
    {
        \$notification = Notification::create(\$title, \$body);
        \$message = CloudMessage::new()
            ->withNotification(\$notification)
            ->withDefaultSounds();

        try {
            \$this->messaging->sendMulticast(\$message, \$deviceTokens);
        } catch (MessagingException|FirebaseException \$e) {
            // Log or handle the exception as needed
        }
    }
}";

            File::ensureDirectoryExists(app_path('Helpers'));
            File::put($helperPath, $helperTemplate);
        }
    }
}