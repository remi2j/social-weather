<?php

include 'api-keys.php';

$friendsAPI = 'https://api.twitter.com/1.1/friends/list.json?screen_name=';

$errorMessages = [];
if (!empty($_GET)) {
  echo 'Hello there, ' .$_GET['handle']. '!';
  $rawFriends = file_get_contents($friendsAPI);
  $friends = json_decode($rawFriends);
  echo '<pre>';
  var_dump($friends);
  echo '</pre>';
}