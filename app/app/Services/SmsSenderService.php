<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsSenderService
{
    public string $login = '';
    public string $pass = '';
    public string $url = '';
    public string $sender = '';

    public function __construct()
    {
        if ($_ENV['SMS_LOGIN']) {
            $this->login = $_ENV['SMS_LOGIN'];
        }
        if ($_ENV['SMS_PASSWORD']) {
            $this->pass = $_ENV['SMS_PASSWORD'];
        }
        if ($_ENV['SMS_SENDER_NAME']) {
            $this->sender = $_ENV['SMS_SENDER_NAME'];
        }
        if ($_ENV['SMS_URL']) {
            $this->url = $_ENV['SMS_URL'];
        }
    }

    /**
     * @param $phone
     * @param $message
     * @return mixed
     */
    public function send($phone, $message): mixed
    {
        if ($this->login && $this->pass && $this->sender && $this->url) {
            $method = '/Send/SendSms';
            $data = [
                'login' => $this->login,
                'pass' => $this->pass,
                'sourceAddress' => $this->sender,
                'destinationAddress' => $phone,
                'data' => $message,
            ];

            $response = Http::get($this->url . $method, $data);

            if($response->ok()) {
                return true;
            } else {
                return $response->json();
            }
        } else {
            return 'Не удалось получить данные для API';
        }
    }
}
