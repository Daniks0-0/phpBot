<?php

namespace App;


use App\Bot;
use Src\Films\Films;

class BotManager
{
    private $bot;
    private $botFilm;

    public function __construct(Bot $bot, Films $botFilm)
    {
        $this->bot = $bot;
        $this->botFilm = $botFilm;
    }

    public function run(): void
    {
        // Запуск основного бота
        $this->bot->run();

        // Запуск бота для фильмов
        $this->botFilm->run();

    // while (true) {
    //     $this->bot->run(); // Один шаг основного бота
    //     $this->botFilm->run(); // Один шаг бота для фильмов

    //     sleep(1); // Пауза между итерациями 
    //     break;
    // }


     }
     

       
    }

