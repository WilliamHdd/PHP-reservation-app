<?php
    // Include the header file that contains
    // - the opening html tags
    // - <head> tags with the necessary style and javascript includes
    // - opening body tag and a bootstrap "container" div
    include 'partials/header.php';
?>

<div id="step-validation">

    <h1>Confirmation</h1>

    <div class="jumbotron">
        <p>
            Voici une récapitulation de vôtre réservation.<br>
            Veuillez vérifier que les informations soient correctes avant de confirmer.
        <p>

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

        <h3>Voyageurs</h3>
        <table>
            <tr>
                <th>N°</th>
                <th>Voyageur</th>
                <th>Age</th>
            </tr>
            <?php foreach ($passengers as $i => $passenger) {
    ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $passenger->name; ?></td>
                    <td><?php echo $passenger->age; ?></td>
                </tr>
            <?php

} ?>
        </table>
    </div>

    <div class="row">
        <form method="post" action="index.php" class="col-md-12">
            <button name="destroy_3" class="btn btn-primary btn-lg">Confirmer</button>
            <button name="destroy_3" class="btn btn-default btn-lg">Anuller</button>
        </form>
    </div>

    <div class="stepwizard row">
        <div class="stepwizard-row">
            <div class="stepwizard-step">
                <button type="button" class="btn btn-default btn-circle">1</button>
                <p>Destination</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-default btn-circle">2</button>
                <p>Détails de réservation</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-primary btn-circle">3</button>
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
