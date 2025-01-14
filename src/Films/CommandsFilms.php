<?php

namespace Src\Films;

use Longman\TelegramBot\Request;

class CommandsFilms{


private $filmsService;
public function __construct(FilmsService $filmsService){
    $this->filmsService = $filmsService;
}
public function handleMessage(int $chatId, string $name) :void{
    if(str_starts_with($name,"Фильм")){
        $nameFilm = trim(str_replace('Фильм', '', $name));
        if(!empty($nameFilm)){
            $filmName = $this->filmsService->getFilms($nameFilm);
            Request::sendMessage([
                'chat_id' => $chatId,
                'text'=> $filmName,
            ]); 
        }else{
            Request::sendMessage([
                'chat_id'=> $chatId,
                'text' =>'Пожалуйста, укажите название фильма полсе команды "Фильм"'
            ]);
        }
}else{
    Request::sendMessage([
        'chat_id'=> $chatId,
        'text'=> 'Я могу показать информацию о фильме. Используйте команду "Фильм <Название фильма>"',
    ]);
}
}
}
