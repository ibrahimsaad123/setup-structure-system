<?php

namespace Saad\SetupStructureSystem\Helpers\Notification;

use Illuminate\Support\Facades\File;

class CreateNotificationJobHelper
{
    public static function createNotificationJob()
    {
        $jobTemplate = self::getNotificationJobTemplate();
        File::ensureDirectoryExists(app_path('Jobs'));
        File::put(app_path('Jobs/SendNotificationJob.php'), $jobTemplate);
    }

    private static function getNotificationJobTemplate(): string
    {
        return <<<'JOB'
<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Notification $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function handle()
    {
        // Logic to send notification
    }
}
JOB;
    }
}