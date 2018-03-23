<?php

include 'api-keys.php';

$weatherURL = 'http://api.openweathermap.org/data/2.5/forecast?q=';

function getWeather(&$place) {
  $weatherData = $weatherURL . $place . '&appid=' . $weatherKey;
  echo '<pre>';
  var_dump($place);
  echo '</pre>';
}

?>