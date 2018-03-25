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
  <header class="home">
    <h1>Social Weather</h1>
    <h2>Your friends forecast</h2>
  </header>
  <section class="twitter-connect">
    <?php
      if (!empty($_GET['error'])) {
        echo '<p class="error">' . $_GET['error'] . '</p>';
      }
    ?>
    <p class="instruction">Enter your Twitter handle:</p>
    <?php include 'includes/twitter-form.php' ?>
  </section>
</body>
</html>