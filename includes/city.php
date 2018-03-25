<?php

// Prepare API calls to Open Weather Map
include 'api-keys.php';
$weatherURL = 'https://api.darksky.net/forecast/' . $weatherKey . '/';

// Append location country if possible
if ($_location->name !== $_location->country) {
  $locationFullName = $_location->name . ', ' . $_location->country;
} else {
   $locationFullName = $_location->name;
}

?>

<div class="city">
  <p class="city-name">
    <?= $locationFullName ?>
  </p>
  <div class="location-card">
    <div class="friends">
      <p class="label">Friends</p>
      <div class="list">
        <?php foreach ($_location->friends as $_friend): ?>
          <p class="name"><?= $_friend ?></p>
        <?php endforeach ?>
      </div>
    </div>
    <div class="forecast">
      <?php for ($i=0; $i<7; $i++): ?>
        <div class="day">
          <?php
            // Get weather data for that location
            $uniqueWeatherURL = $weatherURL . $_location->coords->lat . ',' . $_location->coords->lng;
            // Filter request to only needed data
            $uniqueWeatherURL = $uniqueWeatherURL . '?exludes=currently,minutely,hourly,alerts,flags';
            // Get data from cache if available
            $weatherCachePath = '../cache/weather' . md5($uniqueWeatherURL) . '.txt';
            // Invalidate cache after 90 minutes
            if (file_exists($weatherCachePath) && time() - filemtime($twitterCachePath) < 5400) {
              // From cache
              $weatherData = file_get_contents($weatherCachePath);
            } else {
              // From API
              $weatherData = file_get_contents($uniqueWeatherURL);
              file_put_contents($weatherCachePath, $weatherData);
            }
            $weatherData = json_decode($weatherData);
          ?>

          <div class="label"><?= date('d/m', $weatherData->daily->data[$i]->time) ?></div>
          <?php
            // Extract weather info
            $summary = $weatherData->daily->data[$i]->summary;
            $tempLow = round($weatherData->daily->data[$i]->temperatureLow);
            $tempHigh = round($weatherData->daily->data[$i]->temperatureHigh);
            $humidity = round($weatherData->daily->data[$i]->humidity * 100);
            $windSpeed = round($weatherData->daily->data[$i]->windSpeed);

            // Display gif depending on weather
            if (stripos($summary, 'sun') !== false) {
              $gif = 'sun';
            } else if (stripos($summary, 'cloud') !== false) {
              $gif = 'cloud';
            } else if (stripos($summary, 'rain') !== false) {
              $gif = 'rain';
            } else if (stripos($summary, 'storm') !== false) {
              $gif = 'storm';
            } else if (stripos($summary, 'snow') !== false) {
              $gif = 'snow';
            } else {
              $gif = 'default';
            }
          ?>
          <div class="day-forecast <?= $gif ?>">
            <p class="main"><?= $weatherData->daily->data[$i]->summary ?></p>
            <div>
              <p class="temperature"><?= $tempLow . '°F to ' . $tempHigh . '°F' ?></p>
              <p class="humidity"><?= $humidity ?>% humidity</p>
              <p class="wind"><?= $windSpeed ?> mph wind</p>
            </div>
          </div>
        </div>
      <?php endfor ?>
    </div>
  </div>
</div>