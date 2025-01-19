<?php

namespace App;


use App\Bot;





 class BotManager 
{
    private $bot;


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

