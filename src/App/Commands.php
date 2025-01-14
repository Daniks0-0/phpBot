<?php

namespace App;

use Longman\TelegramBot\Request;

class Commands
{
    private $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function handleMessage(int $chatId, string $text): void
    {
        if (str_starts_with($text, 'Погода')) {
            $city = trim(str_replace('Погода', '', $text));
            if (!empty($city)) {
                $weatherText = $this->weatherService->getWeather($city);
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $weatherText,
                ]);
            } else {
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Пожалуйста, укажите город после команды "Погода".',
                ]);
            }
        }
    }
}