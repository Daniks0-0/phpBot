<?php

//Основной класс бота

namespace App;

use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

class Bot{
    //Хранит объект класса Telegram, который используется для взаимодействия с Telegram API
    private $telegram;
    //Хранит объект класса CommandHandler, который отвечает за обработку входящих сообщений
    private $commands;
    //Конструктор сохраняет переданные объекты в свойства класса
    public function __construct(Telegram $telegram, Commands $commands){
        $this->telegram = $telegram;
        $this->commands = $commands;
       }

    public function run(): void{
        try {
            $this->telegram->useGetUpdatesWithoutDatabase();
            $serverResponse = $this->telegram->handleGetUpdates();

            if ($serverResponse->isOk() && !empty($serverResponse->getResult())) {
                foreach ($serverResponse->getResult() as $update) {
                    $message = $update->getMessage();
                    $this->commands->handleMessage(
                        $message->getChat()->getId(),
                        $message->getText()
                    );
                }
            }
            
        } catch (TelegramException $e) {
            echo 'Ошибка: ' . $e->getMessage();
        }
    }

    }
