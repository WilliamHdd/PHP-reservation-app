<?php
    // Include the header file that contains
    // - the opening html tags
    // - <head> tags with the necessary style and javascript includes
    // - opening body tag and a bootstrap "container" div
    include 'partials/header.php';
?>

<h1> Toute l'équipe vous remercie de votre réservation!</h1>
<p> À bientot!<p>

  <?php

      echo 'Votre réservation pour '.$destination.' a bien été enregistrée '.$insurance.' assurance annulation.'.'<br>'.'<br>';
      echo 'Passagers:'.'<br>'.'<br>';
      foreach ($passengers as $i => $passenger) {
          echo $passenger->name.' '.$passenger->age.'ans'.'<br>';
      }
      echo $result;
  ?>

<form method="post" action="index.php">
    <button name="destroy_3" class="btn btn-primary btn-lg">Y'a pas de quoi.</button>
</form>
