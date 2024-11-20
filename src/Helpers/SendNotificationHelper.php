<?php
    namespace Saad\NotificationSystem\Helpers;

    use Kreait\Firebase\Contract\Messaging;
    use Kreait\Firebase\Exception\FirebaseException;
    use Kreait\Firebase\Exception\MessagingException;
    use Kreait\Firebase\Messaging\CloudMessage;
    use Kreait\Firebase\Messaging\Notification;

    class SendNotificationHelper
    {
        private Messaging $messaging;

        public function __construct(Messaging $messaging)  
        {
            $this->messaging = $messaging;
        }

        // Set a custom messaging instance for testing
        public function setMessaging(Messaging $messaging): void
        {
            $this->messaging = $messaging;
        }

        public function sendMulticast(array $deviceTokens, string $title, string $body): void
        {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withDefaultSounds();

            try {
                $this->messaging->sendMulticast($message, $deviceTokens);
            } catch (MessagingException | FirebaseException $e) {
                // Handle or log exception if needed
            }
        }
    }