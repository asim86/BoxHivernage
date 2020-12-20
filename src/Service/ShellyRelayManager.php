<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ShellyRelayManager
{
    private $httpClient;
    private $auth_key;
    private $deviceID;
    private $channel;
    private $cloudServer = 'https://shelly-2-eu.shelly.cloud';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function triggerRelayToStatus($targetStatus = 'off')
    {
        $actionSubURL = '/device/relay/control';
        $response = $this->httpClient->request(
            'POST',
            $this->cloudServer.$actionSubURL,
            [
                'body' => [
                    'auth_key' => $this->auth_key,
                    'id' => $this->deviceID,
                    'turn' => $targetStatus,
                    'channel' => $this->channel
                ],
                'verify_peer' => false
            ]
        );

        $content = $response->toArray();
        if (key_exists('isok', $content)) {
            if ($content['isok'] == false) {
                // TODO Handle Error
            }
        }
    }
}