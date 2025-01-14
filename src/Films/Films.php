<?php

namespace Src\Films;

use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

class Films
{
    private $telegram;
    private $commandsFilms;

    public function __construct(Telegram $telegram, CommandsFilms $commandsFilms)
    {
        $this->telegram = $telegram;
        $this->commandsFilms = $commandsFilms;
    }

    public function run(): void
    {
        try {
            $this->telegram->useGetUpdatesWithoutDatabase();
            $serverResponse = $this->telegram->handleGetUpdates();

            if ($serverResponse->isOk() && !empty($serverResponse->getResult())) {
                foreach ($serverResponse->getResult() as $update) {
                    $message = $update->getMessage();
                    $text = $message->getText(); // Получаем текст сообщения
                    $chatId = $message->getChat()->getId(); // Получаем ID чата

                    // Обработка команды "Фильм"
                    if (str_starts_with($text, 'Фильм')) {
                        $this->commandsFilms->handleMessage($chatId, $text);
                    }
                }
            }
        } catch (TelegramException $e) {
            echo 'Ошибка: ' . $e->getMessage();
        }
    }
}