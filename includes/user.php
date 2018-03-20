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
    // Use MD5 to normalize location strings
    if (!property_exists($locations, md5($_user->location))) {
      // Create array of users living there
      $locations->{md5($_user->location)} = ['@' .$_user->screen_name];
    } else {
      // Add user to location's array
      array_push($locations->{md5($_user->location)}, '@' .$_user->screen_name);
    }
  }
}

echo '<pre>';
var_dump($locations);
echo '</pre>';
