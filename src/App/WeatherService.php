<?php
//отвечает за взаимодейтсвие с OpenWeatherApi
namespace App;

class WeatherService{
    private $apiKey; //храним api - ключи 
    public function __construct(string $apiKey){ //сохраняем ключи 
        $this ->apiKey = $apiKey; 

    }
    public function getWeather(string $cityName): string{
        
            $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($cityName) . '&units=metric&appid=' . $this->apiKey;
            $response = @file_get_contents($url); // С помощью функции file_get_contents отправляется запрос к API
        if($response === false){
            return 'Не удалось получить данные о погоде. Проверьте название города';
    } 
    $result = json_decode($response, true); //декодируем JSON

//вытаскиваем из json данные (температуру,скорость ветра)
$temp = $result['main']['temp'];
$wind = $result['wind']['speed'];
$weather_type = $result['weather'][0]['id'];

$emoji_icon = '';

if ($weather_type >= 200 && $weather_type <= 232) {
    $emoji_icon = '⚡';
} elseif ($weather_type >= 300 && $weather_type <= 321) {
    $emoji_icon = '🌧';
} elseif ($weather_type >= 500 && $weather_type <= 531) {
    $emoji_icon = '🌧';
} elseif ($weather_type >= 600 && $weather_type <= 622) {
    $emoji_icon = '❄';
} elseif ($weather_type >= 701 && $weather_type <= 781) {
    $emoji_icon = '🌪';
} elseif ($weather_type >= 801 && $weather_type <= 804) {
    $emoji_icon = '⛅';
} elseif ($weather_type == 800) {
    $emoji_icon = '☀';
}

return $cityName . ': ' . $emoji_icon . ' Температура: ' . $temp . '°C, скорость ветра: ' . $wind . ' м/с.';
}
}

