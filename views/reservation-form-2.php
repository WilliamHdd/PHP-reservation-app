<?php
  include 'partials/header.php';
 ?>

<div id="step-2">

      <h1 class="row">Détails de réservation</h1>

      <div class="jumbotron container">
          <h3>Récapitulatif</h3>
          <p class="row">
              <i class="fa fa-plane fa-2x col-md-1"></i>
              <span class="destination col-md-11">
                  <?php echo $trip->get_destination(); ?>
              </span>
          </p>
          <p class="row">
              <?php if ($trip->has_insurance()) {
     ?>
              <i class="fa fa-check fa-2x col-md-1"></i>
              <span class="destination col-md-11">
                  Avec assurance annulation
              </span>
              <?php

 } else {
     ?>
              <i class="fa fa-times fa-2x col-md-1"></i>
              <span class="destination col-md-11">
                  Sans assurance annulation
              </span>
              <?php

 }?>
          </p>
      </div>

      <form method="post" action="index.php">


          <div class="row">

          <?php
          //creating a dictionnary people
          $people = array(); //doesn't work
          $c = 0;
          for ($i = 1; $i < (int) $_POST['places'] + 1; ++$i) {
              ?>

              <div class="col-md-4 passenger">

                  <h5>Voyageur #<?php echo $i; ?> </h4>
                  <div class="form-group">
                      <label for="traveller">Nom</label>
                      <input name="traveller[]" type="text" placeholder="Voyageur" class="form-control"
                      <?php var_dump($trip);
              if (array_key_exists($c, $trip->passengers)) {
                  echo 'value="'.$trip->passengers[$c]->name.'"';
              } ?>/>
                  </div>
                  <div class="form-group">
                      <label for="age">Age</label>
                      <input name="age[]" type="text" placeholder="Age" class="form-control"
                      <?php  if (array_key_exists($c, $trip->passengers)) {
                  echo 'value="'.$trip->passengers[$c]->age.'"';
              } ?>/>
                  </div>
              </div>
              <?php
              $c += 1;
          } ?>
          </div>

          <div class="row">
              <div class="form-group col-md-12">
                  <button name="step_2" class="btn btn-primary" name = "Submit">Suivant</button>
                  <button name="destroy_2" class="btn btn-default">Annulation</button>
              </div>
          </div>
      </form>

      <div class="stepwizard">
          <div class="stepwizard-row">
              <div class="stepwizard-step">
                  <button type="button" class="btn btn-default btn-circle">1</button>
                  <p>Destination</p>
              </div>
              <div class="stepwizard-step">
                  <button type="button" class="btn btn-primary btn-circle">2</button>
                  <p>Détails de réservation</p>
              </div>
              <div class="stepwizard-step">
                  <button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
                  <p>Confirmation</p>
              </div>
          </div>
      </div>

</div>

  <?php
  include 'partials/footer.php';
  ?>
