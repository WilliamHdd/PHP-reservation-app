<?php
    // Include the header file that contains
    // - the opening html tags
    // - <head> tags with the necessary style and javascript includes
    // - opening body tag and a bootstrap "container" div
    include 'partials/header.php';
?>

<div id="step-1">

    <h1 class="row">Réservation</h1>

    <div class="row">

        <div class="jumbotron">
            <h3>Prix des places:</h3>
            <ul>
                <li>Moins de 12 ans = 10€</li>
                <li>Plus de 12 ans = 15€</li>
            </ul>
            Assurance annullation = 20 € peu importe le nombre de voyageurs.
        </div>
    </div>

    <form method="post" action="index.php">

        <div class="row">
            <div class="form-group col-md-6">
                <label for="destination">Destination</label>
                <input type="text" id="destination" name="destination" placeholder="Destination" class="form-control"
                <?php if ($trip != null) {
    echo 'value="'.$trip->get_destination().'"';
}?>/>
            </div>

            <div class="form-group col-md-6">
                <label for="places">Nombre de places</label>
                <input type="number" min="1" id="places" name="places" class="form-control"
                <?php if ($trip != null) {
    echo 'value="'.$trip->get_n_passengers().'"';
}?>/>
            </div>
        </div>


        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" id="insurance" name="insurance" value="valeur" class="form-check-input" <?php if ($trip != null) {
    echo 'checked='.$trip->has_insurance();
}?> />
                Assurance annullation
            </label>
        </div>


        <button type="submit" class="btn btn-primary" name="step_1">Suivant</button>
        <button name="destroy" class="btn btn-default">Annulation</button>


    </form>

    <div class="stepwizard">
        <div class="stepwizard-row">
            <div class="stepwizard-step">
                <button type="button" class="btn btn-primary btn-circle">1</button>
                <p>Destination</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-default btn-circle" disabled="disabled">2</button>
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
    // Include the footer file that contains
    // - javascript includes
    // - all closing tags corresponding to the opening tags in the header
    include 'partials/footer.php';
?>
