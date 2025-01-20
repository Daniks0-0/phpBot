<?php
//отвечает за взаимодейтсвие с OpenWeatherApi
namespace App;
use Longman\TelegramBot\Request;

class WeatherService{
    private $apiKey; //храним api - ключи 
    public function __construct(string $apiKey){ //сохраняем ключи 
        $this ->apiKey = $apiKey; 

    }
    public function getWeather(string $cityName): string{
        
            $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($cityName) . '&units=metric&appid=' . $this->apiKey;
            $response = @file_get_contents($url); // С помощью функции file_get_contents отправляется запрос к API
 
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
public function getWeatherFiveDays(string $cityName): string {
    // Формируем URL для запроса
    $url = 'https://api.openweathermap.org/data/2.5/forecast?q=' . urlencode($cityName) . '&appid=' . $this->apiKey . '&units=metric&lang=ru';

    // Выполняем запрос к API
    $response = @file_get_contents($url);

    // Проверяем, удалось ли получить данные
    if ($response === false) {
        return 'Не удалось найти данные о погоде на 5 дней';
    }

    // Декодируем JSON-ответ
    $result = json_decode($response, true);

    // Массив для хранения данных о погоде
    $weatherData = [];

     // Фильтруем данные, оставляя только 12:00 каждого дня
     $filteredForecasts = array_filter($result['list'], function ($forecast) {
        return date('H', strtotime($forecast['dt_txt'])) === '12'; // Оставляем только 12:00
    });

    // Проходим по каждому отфильтрованному прогнозу
    foreach ($filteredForecasts as $forecast) {
        // Извлекаем дату и время
        $dateTime = $forecast['dt_txt'];

        // Извлекаем температуру
        $temp = $forecast['main']['temp'];

        // Извлекаем скорость ветра
        $wind = $forecast['wind']['speed'];

        // Извлекаем описание погоды
        $weatherDescription = $forecast['weather'][0]['description'];

        // Формируем строку с данными
        $weatherData[] = "{$cityName} - {$dateTime}: Температура {$temp}°C, Ветер {$wind} м/с, Погода: {$weatherDescription}";
    }

    // Возвращаем данные в виде строки
    return $cityName . ":\n" . implode("\n", $weatherData);
}

public function getWeatherConditions(string $cityName): string
{
    $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($cityName) . '&appid=' . $this->apiKey . '&units=metric&lang=ru';
    $response = @file_get_contents($url);
    if ($response === false) {
        return 'Не удалось получить данные о погоде.';
    }

    $result = json_decode($response, true);
    if ((int)$result['cod'] !== 200) {
        return 'Город не найден.';
    }

    $visibility = $result['visibility'] ?? 'Нет данных';
    $windSpeed = $result['wind']['speed'] ?? 'Нет данных';
    $windGust = $result['wind']['gust'] ?? 'Нет данных';

    return $cityName . "\n" .
           'Видимость: ' . $visibility . " м\n" .
           'Скорость ветра: ' . $windSpeed . " м/с\n" .
           'Порыв ветра: ' . $windGust . " м/с";
}

}


  





