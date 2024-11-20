<?php
namespace Saad\NotificationSystem\Tests;

use Saad\NotificationSystem\Helpers\SendNotificationHelper;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\MulticastSendReport;
use PHPUnit\Framework\TestCase;
use Mockery;

class SendNotificationHelperTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testSendMulticast()
    {
        /** @var Messaging|Mockery\MockInterface $mockMessaging */
         $mockMessaging = Mockery::mock(Messaging::class);

        $mockReport = Mockery::mock('overload:' . MulticastSendReport::class);

        $mockMessaging->shouldReceive('sendMulticast')->once()->andReturn($mockReport);

        $helper = new SendNotificationHelper($mockMessaging);

        $deviceTokens = ['token1', 'token2'];
        $title = 'Test Notification';
        $body = 'This is a test notification.';

        $this->assertNull($helper->sendMulticast($deviceTokens, $title, $body));
    }
}