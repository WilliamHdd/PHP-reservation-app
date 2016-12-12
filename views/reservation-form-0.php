<?php
    // Include the header file that contains
    // - the opening html tags
    // - <head> tags with the necessary style and javascript includes
    // - opening body tag and a bootstrap "container" div
    include 'partials/header.php';
?>

<div class="row">
<h1>Bienvenue</h1>
<p>
  Choisissez entre
  <ul>
    <form method="post" action="index.php" class="container">
        <div class="row">
            <button type="submit" class="btn btn-primary" name="new">Nouvelle réservation</button>
            <div class="form-group row">
                <label for="NumRes">Veuillez indiquer votre numéros de réservation:</label>
                <input type="number" id="reserv_ID" name="reserv_ID" class="form-control" />
            </div>
            <button type="submit" name="old" class="btn btn-default" >Accéder à une réservation précédente</button>
        </div>
    </form>
  </ul>
</p>
</div>
