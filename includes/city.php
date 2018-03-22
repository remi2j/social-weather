<?php include 'weather.php' ?>

<div class="city">
  <p class="city-name"><?= $_location ?></p>
  <div class="location-card">
    <div class="friends">
      <p class="label">Friends</p>
      <div class="list">
        <?php foreach ($_users as $_friend): ?>
          <p class="name"><?= $_friend ?></p>
        <?php endforeach ?>
      </div>
    </div>
    <div class="forecast">
      <div class="day">
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