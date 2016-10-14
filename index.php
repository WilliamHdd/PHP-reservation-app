<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Réservation</title>
        <link rel="stylesheet" href="css/style.css">

        <!-- Load bootstrap 4 stylesheets and dependencies -->
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="node_modules/tether/dist/css/tether.min.css">
        <script src="node_modules/jquery/dist/jquery.min.js" charset="utf-8"></script>
    </head>
    <body>
      <div class="container">

        <h1>Réservation</h1>

        <p>  Prix des places: </p>
        <p> Moins de 12 ans = 10€ </p>
        <p> Plus de 12 ans = 15€ </p>
        <p> Assurance reservation = 20 € peu important le nombre de voyageurs. </p>

        <form method="post" action="reservation_step_1.php">
          <p> Destination: <input type="text" placeholder="Destination" name = "destination"/> </p>

          <p> Nombre de places:<input type="number" name="places"/> </p>
          <p> Assurance annulation? <input type="checkbox" value="valeur" name="assurance"/> </p>

          <button type="submit" class="btn btn-primary btn-lg" name = "Submit">Suivant</button>
          <button name="destroy" class="btn btn-default btn-lg">Annulation</button>
        </form>


      </div>

        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js" charset="utf-8"></script>
        <script src="node_modules/tether/dist/js/tether.min.js" charset="utf-8"></script>
    </body>

</html>
