<?php

// Prepare API calls to Open Weather Map
include 'api-keys.php';
$weatherURL = 'https://api.openweathermap.org/data/2.5/forecast/daily?q=';

?>

<div class="city">
  <p class="city-name"><?= $_location ?></p>
  <div class="location-card">
    <div class="friends">
      <p class="label">Friends</p>
      <div class="list">
        <?php foreach ($_users->friends as $_friend): ?>
          <p class="name"><?= $_friend ?></p>
        <?php endforeach ?>
      </div>
    </div>
    <div class="forecast">
      <div class="day">
        <?php
          // Get weather data for that location
          //$weatherData = file_get_contents($weatherURL . $_location . '&appid=' . $weatherKey . '&cnt=4');
          //echo '<pre>';
          //var_dump($weatherData);
          //echo '</pre>';
        ?>

        <div class="label">March 18th</div>
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