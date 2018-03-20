<?php

include 'api-keys.php';
include 'twitter-wrapper.php';

$friendsURL = 'https://api.twitter.com/1.1/friends/list.json';
$requestMethod = 'GET';
$userParam = '?screen_name=' .$_GET['handle'];

$twitter = new TwitterAPIExchange($settings);

echo $twitter
  ->setGetfield($userParam)
  ->buildOauth($friendsURL, $requestMethod)
  ->performRequest();





//echo 'Hello there, ' .$_GET['handle']. '!';