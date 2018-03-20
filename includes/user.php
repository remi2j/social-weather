<?php

include 'api-keys.php';
include 'twitter-wrapper.php';

// Check if cached data exists
$cachePath = '../cache/' .$_GET['handle']. '.txt';

if (file_exists($cachePath)) {
  // Get friends from cache
  $friends = file_get_contents($cachePath);
  $friends = json_decode($friends);
} else {
  // Get friends from Twitter API
  $twitter = new TwitterAPIExchange($settings);
  // Prepare request parameters
  $friendsURL = 'https://api.twitter.com/1.1/friends/list.json';
  $requestMethod = 'GET';
  $userParam = '?screen_name=' .$_GET['handle'];

  // Make the request
  $friends = $twitter
    ->setGetfield($userParam)
    ->buildOauth($friendsURL, $requestMethod)
    ->performRequest();

  // Cache for future sessions
  file_put_contents($cachePath, json_encode($friends));
}

// Turn JSON into object
$friends = json_decode($friends);

// Get locations from friends list
$locations = new stdClass();

foreach ($friends->users as $_user) {
  // Save location if it exists
  if ($_user->location !== '') {
    // Find location with Google Maps
    $mapsAPI = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
    $mapsURL = $mapsAPI . $_user->location . '&key=' . $mapsKey;
    $mapsURL = str_replace(' ', '%20', $mapsURL);
    $mapsData = file_get_contents($mapsURL);
    $mapsData = json_decode($mapsData);
    
    // Normalize location name
    $normalizedLocation = $mapsData->results[0]->address_components[0]->long_name;

    if (!property_exists($locations, $normalizedLocation)) {
      // Create array of users living there
      $locations->{$normalizedLocation} = ['@' . $_user->screen_name];
    } else {
      // Add user to location's array
      array_push($locations->{$normalizedLocation}, '@' . $_user->screen_name);
    }
  }
}

echo '<pre>';
var_dump($locations);
echo '</pre>';
