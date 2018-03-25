<?php
  $path = getcwd();
  // Adapt path to working directory
  if (stripos($path, 'includes') !== false) {
    $path = 'user.php';
  } else {
    $path = 'includes/user.php';
  }
?>

<form class="twitter-form" action="<?= $path ?>" method="get">
  <label for="handle" class="at">@</label>
  <input type="search" name="handle" id="handle" class="search" placeholder="username" autofocus>
  <input type="submit" class="go" value="Go">
</form>