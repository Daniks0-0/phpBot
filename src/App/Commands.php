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
    switch (true) {
        case str_starts_with($text, 'Погода 5'):
            $city = trim(str_replace('Погода 5', '', $text));
            if (!empty($city)) {
                $city = ucfirst($city); // Приводим город к правильному регистру
                $weatherText = $this->weatherService->getWeatherFiveDays($city);
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $weatherText,
                ]);
            } else {
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Пожалуйста, укажите город после команды "Погода5дней". Например: "Погода 5 Москва".',
                ]);
            }
            break;

        case str_starts_with($text, 'Погода'):
            $city = trim(str_replace('Погода', '', $text));
            if (!empty($city)) {
                $city = ucfirst($city); // Приводим город к правильному регистру
                $weatherText = $this->weatherService->getWeather($city);
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $weatherText,
                ]);
            } else {
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Пожалуйста, укажите город после команды "Погода". Например: "Погода Москва".',
                ]);
            }
            break;

            case str_starts_with($text, 'Ветер'):
                $city = trim(str_replace('Ветер', '', $text));
                if (!empty($city)) {
                  
                    $weatherText = $this->weatherService->getWeatherConditions($city);
                    Request::sendMessage([
                        'chat_id' => $chatId,
                        'text' => $weatherText,
                    ]);
                } else {
                    Request::sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'Пожалуйста, укажите город после команды "Ветер". Например: "Ветер Москва".',
                    ]);
                }
                break;

        default:
            Request::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Введите пожалуйста команду ещё раз. Доступные команды: "Погода", "Погода 5", "Ветер".',
            ]);
            break;
    }
}
}