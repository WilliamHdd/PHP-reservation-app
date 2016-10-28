<?php
  include 'partials/header.php';
 ?>
    <body>
      <h1>Détails de réservation:</h1>
      <p> Voyage vers <?php echo $trip->get_destination().':'; ?> </p>
      <?php
      if ($trip->has_insurance()) {
          echo 'Avec assurance annulation.<br><br>';
      } else {
          echo 'Sans assurance annulation.<br><br>';
      }

      ?>
      <form method="post" action="index.php">
      <?php
      //creating a dictionnary people
      $people = array(); //doesn't work

      for ($i = 1; $i < (int) $_POST['places'] + 1; ++$i) {
          echo 'Voyageur ', $i; ?>
          <p> Nom: <input name="traveller[]" type="text" placeholder="Voyageur" /></p>
          <p> Age: <input name="age[]" type="text" placeholder="Age" /></p>
          <?php

      } ?>

      <p>
        <button name="step_2" class="btn btn-primary btn-lg" name = "Submit">Suivant</button>
        <button name="destroy_2" class="btn btn-default btn-lg">Annulation</button>
      </p>
      </form>
      <?php

      include 'partials/footer.php';

      ?>
      </body>
