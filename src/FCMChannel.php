<?php

namespace NotificationChannels\FCM;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Notification;
use LaravelFCM\Sender\FCMSender;
use NotificationChannels\FCM\Exceptions\CouldNotSendNotification;

class FCMChannel
{
    /**
     * @var \LaravelFCM\Sender\FCMSender
     */
    protected $sender;

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * Constructor.
     *
     * @param  \LaravelFCM\Sender\FCMSender  $sender
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     */
    public function __construct(FCMSender $sender, Dispatcher $events)
    {
        $this->sender = $sender;
        $this->events = $events;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\FCM\Exceptions\CouldNotSendNotification
     *
     * @return \LaravelFCM\Response\DownstreamResponse|null
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toFCM($notifiable);
        if ($message->recipientNotGiven()) {
            $to = $notifiable->routeNotificationFor('FCM');
            if (is_array($to) && empty($to)) {
                return;
            }
            if (! $to) {
                throw CouldNotSendNotification::missingRecipient();
            }
            $message->to($to);
        }
        $method = 'sendTo';
        if ($message instanceof FCMMessageTopic) {
            $method .= 'Topic';
        } elseif ($message instanceof FCMMessageGroup) {
            $method .= 'Group';
        }

        $response = $this->sender->{$method}(...$message->getArgs());

        $this->events->dispatch(new MessageWasSended($response, $notifiable));

        return $response;
    }
}
