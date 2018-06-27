<?php


namespace App\Services;

// TODO: will create http-client or require guzzle

class Sms implements SmsSender
{
    private $apiId;
    private $url;

    public function __construct($apiId, $url = 'https://sms_api/sms/send')
    {
        $this->apiId = $apiId;
        $this->url = $url;
    }

    public function send($number, $text): void
    {
        // TODO: Implement send() method.
    }
}