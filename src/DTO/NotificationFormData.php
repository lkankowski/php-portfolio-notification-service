<?php

declare(strict_types=1);

namespace App\DTO;

final class NotificationFormData
{
    private string $notificationId;
    private string $message;

    public function __construct(
        string $message = '',
    )
    {
        $this->message = $message;
    }

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
