<?php

require __DIR__ . '/vendor/autoload.php';

use App\Bot;
use App\Commands;
use App\WeatherService;
use Longman\TelegramBot\Telegram;

// Загрузка переменных окружения
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Проверка наличия переменных окружения
if (empty($_ENV['TELEGRAM_BOT_API_KEY']) || empty($_ENV['TELEGRAM_BOT_USERNAME'])) {
    die('Переменные окружения TELEGRAM_BOT_API_KEY или TELEGRAM_BOT_USERNAME не определены.');
}

// Конфигурация
$config = require __DIR__ . '/config/config.php';

// Инициализация зависимостей
$weatherService = new WeatherService($config['open_weather_map']['api_key']);
$commands = new Commands($weatherService);
$telegram = new Telegram($config['telegram']['api_key'], $config['telegram']['username']);

// Запуск бота
$bot = new Bot($telegram, $commands);
$bot->run();