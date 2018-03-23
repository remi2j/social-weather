<?php

// Prepare API calls to Open Weather Map
include 'api-keys.php';
$weatherURL = 'https://api.darksky.net/forecast/' . $weatherKey . '/';

?>

<div class="city">
  <p class="city-name"><?= $_location ?></p>
  <div class="location-card">
    <div class="friends">
      <p class="label">Friends</p>
      <div class="list">
        <?php foreach ($_locationDetails->friends as $_friend): ?>
          <p class="name"><?= $_friend ?></p>
        <?php endforeach ?>
      </div>
    </div>
    <div class="forecast">
      <?php for ($i=0; $i<7; $i++): ?>
        <div class="day">
          <?php
            // Get weather data for that location
            $uniqueWeatherURL = $weatherURL . $_locationDetails->coords->lat . ',' . $_locationDetails->coords->lng;
            // Filter request to only needed data
            $uniqueWeatherURL = $uniqueWeatherURL . '?exludes=currently,minutely,hourly,alerts,flags';
            // Get data from cache if available
            $weatherCachePath = '../cache/weather' . md5($uniqueWeatherURL) . '.txt';
            if (file_exists($weatherCachePath)) {
              echo 'from cache <br>';
              $weatherData = file_get_contents($weatherCachePath);
            } else {
              echo 'from api <br>';
              // Or from API
              $weatherData = file_get_contents($uniqueWeatherURL);
              file_put_contents($weatherCachePath, $weatherData);
            }
            $weatherData = json_decode($weatherData);
          ?>

          <div class="label"><?= date('d/m', $weatherData->daily->data[$i]->time) ?></div>
          <div class="day-forecast">
            <p class="main">light intensity shower rain</p>
            <p class="temperature">18 degrees</p>
            <p class="humidity">42% humidity</p>
            <p class="wind">1.2 mph wind</p>
          </div>
        </div>
      <?php endfor ?>
    </div>
  </div>
</div>