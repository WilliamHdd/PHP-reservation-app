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

          <div class="row">

              <h1>Réservation</h1>

              <p>
                  Prix des places:
                  <ul>
                      <li>Moins de 12 ans = 10€</li>
                      <li>Plus de 12 ans = 15€</li>
                  </ul>
                  Assurance reservation = 20 € peu importe le nombre de voyageurs.
              </p>

              <form method="post" action="reservation_step_1.php" class="container">
                  <div class="form-group row">
                      <label for="destination">Destination</label>
                      <input type="text" id="destination" name="destination" placeholder="Destination" class="form-control" />
                  </div>

                  <div class="form-group row">
                      <label for="places">Nombre de places</label>
                      <input type="number" id="places" name="places" class="form-control" />
                  </div>

                  <div class="form-check row">
                      <label class="form-check-label">
                          <input type="checkbox" id="insurance" name="insurance" value="valeur" class="form-check-input" />
                          Cancellation Insurance
                      </label>
                  </div>

                  <div class="row">
                      <button type="submit" class="btn btn-primary" name = "Submit">Suivant</button>
                      <button name="destroy" class="btn btn-default">Annulation</button>
                  </div>

              </form>

          </div>

      </div>

        <script src="node_modules/tether/dist/js/tether.min.js" charset="utf-8"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js" charset="utf-8"></script>
    </body>

</html>
