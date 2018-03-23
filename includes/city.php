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
      <div class="day">
        <?php
          // Get weather data for that location
          $uniqueWeatherURL = $weatherURL . $_locationDetails->coords->lat . ',' . $_locationDetails->coords->lng;
          // Filter request to only needed data
          $uniqueWeatherURL = $uniqueWeatherURL . '?exludes=currently,minutely,hourly,alerts,flags';
          $weatherData = file_get_contents($uniqueWeatherURL);
          $weatherData = json_decode($weatherData);
        ?>

        <div class="label"><?= date('d/m', $weatherData->daily->data[0]->time) ?></div>
        <div class="day-forecast">
          <p class="main">light intensity shower rain</p>
          <p class="temperature">18 degrees</p>
          <p class="humidity">42% humidity</p>
          <p class="wind">1.2 mph wind</p>
        </div>
      </div>
    </div>
  </div>
</div>