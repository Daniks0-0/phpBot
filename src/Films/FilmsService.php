<?php 
//взаимодействие с api 
namespace Src\Films;
class FilmsService{
    private $apiKey; //ключ api 

    public function __construct(string $apiKey){
        $this->apiKey = $apiKey;
    }
    public function getFilms(string $filmsName) : string{
        $url = 'http://www.omdbapi.com/?apikey='.$this->apiKey . '&t=' . urlencode($filmsName);
        $response = @file_get_contents($url); //отправляем запрос к api
        if($response === false){
            return 'Не удалось найти информацию об этом фильме';
        }

        // Декодируем JSON-ответ
        $data = json_decode($response, true);

        // Проверяем, найден ли фильм
        if ($data['Response'] === 'False') {
            return 'Фильм не найден. Проверьте название.';
        }


        //вытаскиваем данные из json
        $titleFilms =  $data['Title'];
        $filmsYear = $data['Year'];
        $filmsPlot = $data['Plot'];
        $filmsPoster = $data['Poster'];

        return 'Название фильма: '.$titleFilms . ". Год выпуска: ".$filmsYear . ". Описание: ".$filmsPlot . ". Постер:".$filmsPoster;
    }
}
