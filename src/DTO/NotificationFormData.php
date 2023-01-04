<?php

declare(strict_types=1);

namespace App\DTO;

final class NotificationFormData
{
    public const NOTIFICATIONS = [
        'Sample notification 1' => 'notification1',
        'Sample notification 2' => 'notification2',
        'Sample notification 3' => 'notification3',
        'Sample notification 4' => 'notification4',
    ];

    private string $notificationId;
    private string $message;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getNotificationId(): string
    {
        return $this->notificationId;
    }

    public function setNotificationId(string $notificationId): void
    {
        $this->notificationId = $notificationId;
    }
}
