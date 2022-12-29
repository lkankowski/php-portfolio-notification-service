<?php

declare(strict_types=1);

namespace App\DTO;

final class NotificationFormData
{
    private string $phoneNumber;
    private string $email;
    private string $pushyRecipient;
    private string $message;

    public function __construct(
        string $phoneNumber = '',
        string $email = '',
        string $pushyToken = '',
        string $message = '',
    )
    {
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->pushyRecipient = $pushyToken;
        $this->message = $message;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPushyRecipient(): string
    {
        return $this->pushyRecipient;
    }

    public function setPushyRecipient(string $pushyRecipient): void
    {
        $this->pushyRecipient = $pushyRecipient;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
