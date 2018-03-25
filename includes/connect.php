<section class="twitter-connect">
  <?php
    if (!empty($_GET['error'])) {
      echo '<p class="error">' . $_GET['error'] . '</p>';
    }
  ?>
  <p class="instruction">Enter your Twitter handle:</p>
  <?php include 'twitter-form.php' ?>
</section>