<form class="twitter-form" action="<?= $_SERVER['HTTP_REFERER'] ?>includes/user.php" method="get">
    <label for="handle" class="at">@</label>
    <input type="search" name="handle" id="handle" class="search" placeholder="username" autofocus>
    <input type="submit" class="go" value="Go">
  </form>