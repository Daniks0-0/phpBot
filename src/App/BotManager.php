<?php

namespace App;


use App\Bot;
use Src\Films\CommandsFilms;
use Src\Films\Films;





 class BotManager 
{
    private $bot;
    private $botFilm;

    public function __construct(Bot $bot)
    {
        $this->bot = $bot;
     
    }

    public function run(): void
    {
        // Запуск основного бота
        $this->bot->run();

     
    }
}

