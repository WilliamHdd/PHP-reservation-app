<?php
    // Include the header file that contains
    // - the opening html tags
    // - <head> tags with the necessary style and javascript includes
    // - opening body tag and a bootstrap "container" div
    include 'partials/header.php';
?>

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

    <form method="post" action="index.php" class="container">
        <div class="form-group row">
            <label for="destination">Destination</label>
            <input type="text" id="destination" name="destination" placeholder="Destination" class="form-control"
            <?php if ($trip != null) {
    echo 'value="'.$trip->get_destination().'"';
}?>/>
        </div>

        <div class="form-group row">
            <label for="places">Nombre de places</label>
            <input type="number" min="1" id="places" name="places" class="form-control"
            <?php if ($trip != null) {
    echo 'value="'.$trip->get_n_passengers().'"';
}?>/>
        </div>

        <div class="form-check row">
            <label class="form-check-label">
                <input type="checkbox" id="insurance" name="insurance" value="valeur" class="form-check-input" <?php if ($trip != null) {
    echo 'checked='.$trip->has_insurance();
}?> />
                Cancellation Insurance
            </label>
        </div>

        <div class="row">
            <button type="submit" class="btn btn-primary" name="step_1">Suivant</button>
            <button name="destroy" class="btn btn-default">Annulation</button>
        </div>

    </form>

</div>

<?php
    // Include the footer file that contains
    // - javascript includes
    // - all closing tags corresponding to the opening tags in the header
    include 'partials/footer.php';
?>
