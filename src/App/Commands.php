<?php
//обработка команд бота

namespace App;

use Longman\TelegramBot\Request;

class Commands{
    //хранит объект класса WeatherService. Оно используется для получения информации о погоде.
    private $weatherService; 

    public function __construct(WeatherService $weatherService){
        $this->weatherService =$weatherService;
    }
    public function handleMessage(int $chatId, string $text):void{

        //проверка начинается ли команда со слова "Погода"
        if (str_starts_with($text, "Погода")) {
            $cityName = trim(str_replace('Погода', '', $text));

            if (!empty($cityName)) {
                $weatherText = $this->weatherService->getWeather($cityName);
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $weatherText,
                ]);
            } else {
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Пожалуйста, укажите город после команды "Погода".',
                ]);
            }
        } else {
            Request::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Я могу показать погоду. Используйте команду "Погода <город>".',
            ]);
        }
    }
}
    
                
                

                
