<?php

require __DIR__ . '/vendor/autoload.php';

use App\Bot;
use App\BotManager;
use App\Commands;
use App\WeatherService;
use Longman\TelegramBot\Telegram;
use Src\Films\CommandsFilms;
use Src\Films\FilmsService;
use Src\Films\Films;

// Загрузка переменных окружения
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Проверка наличия переменных окружения
if (empty($_ENV['TELEGRAM_BOT_API_KEY']) || empty($_ENV['TELEGRAM_BOT_USERNAME'])) {
    die('Переменные окружения TELEGRAM_BOT_API_KEY или TELEGRAM_BOT_USERNAME не определены.');
}
if (empty($_ENV['OMDb_API_KEY'])) {
    die('Переменные окружения OMDb_API_KEY не определены.');
}

// Конфигурация
$config = require __DIR__ . '/config/config.php';

// Инициализация зависимостей
$weatherService = new WeatherService($config['open_weather_map']['api_key']);
$commands = new Commands($weatherService);

// Инициализация зависимостей для OMBd
$filmsService = new FilmsService($config['omdb_films_api']['api_key']);
$commandsFilms = new CommandsFilms($filmsService);

// Общая часть инициализации
$telegram = new Telegram($config['telegram']['api_key'], $config['telegram']['username']);

// Создание ботов
$bot = new Bot($telegram, $commands);


// Запуск менеджера ботов
$botManager = new BotManager($bot);
$botManager->run();
