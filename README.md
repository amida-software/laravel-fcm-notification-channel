# FCM notification channel for Laravel 6.x

This package makes it easy to send notifications using [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/) (FCM) with Laravel 5.3.
This package is based on [brozot/laravel-fcm](https://github.com/brozot/Laravel-FCM), so please read that documentation for more information.

## Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Available message types](#available-message-types)
    - [Available message methods](#available-message-methods)
- [Testing](#testing)
- [Credits](#credits)
- [Support](#support)
- [License](#license)


## Installation

Before installation you should to add the following code to your `composer.json` file :
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/ahmed-aliraqi/laravel-fcm-notification-channel"
    }
],
```

Now you can install this package via composer:

``` bash
composer require enniel/laravel-fcm-notification-channel
```

## Package Configuration

In your `.env` file, add the server key and the secret key for the Firebase Cloud Messaging:

```dotenv
FCM_SERVER_KEY=my_secret_server_key
FCM_SENDER_ID=my_secret_sender_id
```

To get these keys, you must create a new application on the [firebase cloud messaging console](https://console.firebase.google.com/).

After the creation of your application on Firebase, you can find keys in `project settings -> cloud messaging`.



## Usage

Now you can use the channel in your `via()` method inside the notification:

```php
use NotificationChannels\FCM\FCMMessage;
use Illuminate\Notifications\Notification;

class ExampleNotification extends Notification
{
    public function via($notifiable)
    {
        return ['fcm'];
    }

    public function toFCM($notifiable)
    {
        return (new FCMMessage())
            ->data([
                'title' => 'Notification title',
                'body' => 'Notification body',
            ]);
    }
}
```

### Available message types:

- `FCMMessage`: Send notifications to device(s).
- `FCMMessageTopic`: Send notifications to topic(s).
- `FCMMessageGroup`: Send notifications to group(s).

In order for your notice to know who to send messages, you must add `routeNotificationForFCM` method to your notification model.

### Available message methods

- `data()`: Notification data. `array` | `LaravelFCM\Message\PayloadData` | `LaravelFCM\Message\PayloadDataBuilder`
- `options()`: Notification options. `array` | `LaravelFCM\Message\Options` | `LaravelFCM\Message\OptionsBuilder`
- `notification()`: Notification content. `array` | `LaravelFCM\Message\PayloadNotification` | `LaravelFCM\Message\PayloadNotificationBuilder`

### Proxy methods. See [brozot/laravel-fcm](https://github.com/brozot/Laravel-FCM) for more information about this methods.
- `setDryRun`
- `setPriority`
- `setTimeToLive`
- `setCollapseKey`
- `setDelayWhileIdle`
- `setMutableContent`
- `setContentAvailable`
- `setRestrictedPackageName`
- `isDryRun`
- `getPriority`
- `getTimeToLive`
- `getCollapseKey`
- `isDelayWhileIdle`
- `isMutableContent`
- `isContentAvailable`
- `getRestrictedPackageName`
- `setTag`
- `setBody`
- `setIcon`
- `setTitle`
- `setSound`
- `setBadge`
- `setColor`
- `setChannelId`
- `setClickAction`
- `setBodyLocationKey`
- `setBodyLocationArgs`
- `setTitleLocationKey`
- `setTitleLocationArgs`
- `getTag`
- `getBody`
- `getIcon`
- `getTitle`
- `getSound`
- `getBadge`
- `getColor`
- `getChannelId`
- `getClickAction`
- `getBodyLocationKey`
- `getBodyLocationArgs`
- `getTitleLocationKey`
- `getTitleLocationArgs`

## Testing

``` bash
$ composer test
```

## Credits

- [Evgeni Razumov](https://github.com/enniel)
- [All Contributors](../../contributors)

## Support

Having trouble? Open an issue!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
