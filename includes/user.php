<?php

include 'api-keys.php';
include 'twitter-wrapper.php';

// Reset error message
$errorMessage = '';

// Check if cached data exists
$twitterCachePath = '../cache/user' . $_GET['handle'] . '.txt';

if (file_exists($twitterCachePath)) {
  // Get friends from cache
  $friends = file_get_contents($twitterCachePath);
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

  $friends = json_decode($friends);

  // Check if request was successful
  $errorMessage = $friends->errors[0]->message ? : '';
  if ($errorMessage === '') {
    // Cache for future sessions
    file_put_contents($twitterCachePath, json_encode($friends));
  } else {
    // Display error message
    die($errorMessage);
  }


}

$friends = json_decode($friends);

// Get locations from friends list
$locations = new stdClass();

foreach ($friends->users as $_user) {
  // Save location if it exists
  if ($_user->location !== '') {
    // Identify location
    $cityCachePath = '../cache/city' . md5($_user->location) . '.txt';
    if (file_exists($cityCachePath)) {
      // echo 'from cache <br>';
      // Get maps data from cache if available
      $mapsData = json_decode($cityCachePath);
    } else {
      // echo 'from api <br>';
      // Find location with Google Maps
      $mapsAPI = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
      $mapsURL = $mapsAPI . $_user->location . '&key=' . $mapsKey;
      $mapsURL = str_replace(' ', '%20', $mapsURL);
      $mapsData = file_get_contents($mapsURL);
      $mapsData = json_decode($mapsData);
      // Cache for future sessions
      file_put_contents($cityCachePath, json_encode($mapsData));
    }
    
    // Normalize location name
    if (count($mapsData->results) > 0) {
      $normalizedLocation = $mapsData->results[0]->address_components[0]->long_name;
    } else {
      $user->location = '';
      // Delete cached file
      unlink($cityCachePath);
    }

    if (isset($normalizedLocation) && !property_exists($locations, $normalizedLocation)) {
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
