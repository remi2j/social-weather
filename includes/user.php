<?php

include 'api-keys.php';
include 'twitter-wrapper.php';

// Check if cached data exists
$cachePath = '../cache/' .$_GET['handle']. '.txt';

if (file_exists($cachePath)) {
  // Get friends from cache
  echo 'from cache <br>';
  $friends = file_get_contents($cachePath);
  $friends = json_decode($friends);
} else {
  // Get friends from Twitter API
  echo 'from API <br>';
  // Prepare request parameters
  $twitter = new TwitterAPIExchange($settings);
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

echo $friends;