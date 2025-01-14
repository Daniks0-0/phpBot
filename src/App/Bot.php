<?php

namespace App;

use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

class Bot
{
    private $telegram;
    private $commands;

    public function __construct(Telegram $telegram, Commands $commands)
    {
        $this->telegram = $telegram;
        $this->commands = $commands;
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

                    // Обработка команды "Погода"
                    if (str_starts_with($text, 'Погода')) {
                        $this->commands->handleMessage($chatId, $text);
                    }
                }
            }
        } catch (TelegramException $e) {
            echo 'Ошибка: ' . $e->getMessage();
        }
    }
}