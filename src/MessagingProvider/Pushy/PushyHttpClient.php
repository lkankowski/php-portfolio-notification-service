<?php

declare(strict_types=1);

namespace App\MessagingProvider\Pushy;

use App\MessagingProvider\UnableToSendNotificationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PushyHttpClient
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $apiUrl,
        private readonly string $apiKey,
    )
    {}

    /**
     * @throws UnableToSendNotificationException
     * @throws TransportExceptionInterface
     *
     * @param string[] $to
     */
    public function sendPushNotification(string $message, array $to, array $options): void
    {
        $url = $this->apiUrl . '/push?api_key=' . $this->apiKey;

        $post = $options ?: [];
        $post['to'] = $to;
        $post['data'] = ['message' => $message];

        $jsonResult = $response = null;
        try {
            $response = $this->httpClient->request(Request::METHOD_POST, $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'body' => \json_encode($post, \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR),
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new UnableToSendNotificationException('Pushy', $response->getStatusCode(), $response->getContent(false));
            }

            $jsonResult = \json_decode($response->getContent(false), flags: \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new UnableToSendNotificationException('Pushy', $response->getStatusCode(), $response->getContent(false));
        } catch (TransportExceptionInterface $ex) {
            throw new UnableToSendNotificationException('Pushy', $ex->getCode(), $ex->getMessage());
        }

        if (isset($jsonResult->error)) {
            throw new UnableToSendNotificationException('Pushy', $response->getStatusCode(), $response->getContent(false));
        }
    }
}
