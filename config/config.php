<?php
//хранится настройка проекта

return [
    'telegram' => [
        'api_key' => $_ENV['TELEGRAM_BOT_API_KEY'] ?? null,
        'username' => $_ENV['TELEGRAM_BOT_USERNAME'] ?? null,
    ],
    'open_weather_map' => [
        'api_key' => $_ENV['OPEN_WEATHER_MAP_API_KEY'] ?? null,
    ],
];