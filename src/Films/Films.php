<?php

namespace Films;


use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

//класс для работы с TMDB Api в телеграмм 
class Films{
      //Хранит объект класса Telegram, который используется для взаимодействия с Telegram API
      private $telegram;
      private $commandsFilms;

      public function __construct(Telegram  $telegram, CommandsFilms $commandsFilms){
        $this->telegram = $telegram;
        $this->commandsFilms = $commandsFilms;
}

public function run():void{
  try {
    $this->telegram->useGetUpdatesWithoutDatabase();
    $serverResponse = $this->telegram->handleGetUpdates();

    if ($serverResponse->isOk() && !empty($serverResponse->getResult())) {
        foreach ($serverResponse->getResult() as $update) {
            $message = $update->getMessage();
            $this->commandsFilms->handleMessage(  //будет реализована функция в классе CommandsFilms (проверка на вводное слово для начала команды)
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