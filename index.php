<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles/reset.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <title>Social Weather</title>
</head>
<body>
  <?php include "imports/header.php" ?>
  <?php include "imports/twitter-connect.php" ?>
  <section class="cities">
    <?php include "imports/city.php" ?>
  </section>
</body>
</html>