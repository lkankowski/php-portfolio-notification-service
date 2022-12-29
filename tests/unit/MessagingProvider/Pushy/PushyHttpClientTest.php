<?php

declare(strict_types=1);

namespace App\Tests\unit\MessagingProvider\Pushy;

use App\MessagingProvider\Pushy\PushyHttpClient;
use App\MessagingProvider\UnableToSendNotificationException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class PushyHttpClientTest extends TestCase
{
    private HttpClientInterface & MockObject $httpClient;
    private PushyHttpClient $sut;

    public function testSendPushNotificationSuccess(): void
    {
        $lazyResponse = $this->createMock(ResponseInterface::class);

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with(
                Request::METHOD_POST,
                $this->stringContains('secret'),
                $this->callback(fn($item) =>
                    is_array($item) && isset($item['body']) && \mb_strpos($item['body'], 'some message'))
            )
            ->willReturn($lazyResponse);

        $lazyResponse->method('getStatusCode')->willReturn(200);
        $lazyResponse->method('getContent')->willReturn('{}');

        $this->sut->sendPushNotification('some message', 'receipient', []);
    }

    public function testSendPushNotificationFailWhenInvalidJson(): void
    {
        $lazyResponse = $this->createMock(ResponseInterface::class);

        $this->httpClient->expects($this->once())->method('request')->willReturn($lazyResponse);

        $lazyResponse->method('getStatusCode')->willReturn(200);
        $lazyResponse->method('getContent')->willReturn('dummy');

        $this->expectException(UnableToSendNotificationException::class);

        $this->sut->sendPushNotification('{}', 'token', []);
    }

    public function testSendPushNotificationFailWhenTransportException(): void
    {
        $lazyResponse = $this->createMock(ResponseInterface::class);

        $this->httpClient->expects($this->once())->method('request')->willReturn($lazyResponse);

        $lazyResponse->method('getStatusCode')->willThrowException(new TransportException());

        $this->expectException(UnableToSendNotificationException::class);

        $this->sut->sendPushNotification('{}', 'token', []);
    }

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);

        $this->sut = new PushyHttpClient($this->httpClient, 'http://localhost', 'secret');
    }
}
