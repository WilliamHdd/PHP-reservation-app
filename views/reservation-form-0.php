<?php
    // Include the header file that contains
    // - the opening html tags
    // - <head> tags with the necessary style and javascript includes
    // - opening body tag and a bootstrap "container" div
    include 'partials/header.php';
?>



<div id="index-page">
    <h1 class="row">Bienvenue</h1>

    <div class="row">
        <div class="col-md-6">
            <form method="post" action="index.php" class="container">
                <button id="new-reservation" type="submit" class="btn btn-primary big" name="new">
                    Nouvelle réservation
                </button>
            </form>
        </div>

        <div class="col-md-6">
            <form method="post" action="index.php" class="container">
                <button id="old-reservations" type="submit" class="btn btn-primary big" name="old">
                    Accéder à une réservation
                </button>
            </form>
        </div>
    </div>


    <table class="table table-sm">
        <thead>
            <tr>
                <th class="text-xs-center">ID</th>
                <th class="text-xs-center">Destination</th>
                <th class="text-xs-center">Assurance</th>
                <th class="text-xs-center">Modification</th>
                <th class="text-xs-center">Suppression</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $reservations = Reservation::list_reservations();

            foreach ($reservations as $res) {
                echo '<tr>';
                echo '<td class="text-xs-center">'.$res['id'].'</td>';
                echo '<td class="text-xs-center">'.$res['destination'].'</td>';
                echo '<td class="text-xs-center">'.$res['insurance'].'</td>';

                echo '<td class="text-xs-center edit">
                        <form method="post" action="index.php">
                            <button type="submit" class="btn btn-warning btn-sm" name="edit" value="'.$res['id'].'">Modifier</button>
                        </form>
                      </td>';

                echo '<td class="text-xs-center delete">
                        <form method="post" action="index.php">
                            <button type="submit" class="btn btn-danger btn-sm" name="remove" value="'.$res['id'].'">Supprimer</button>
                        </form>
                      </td>';
                echo '</tr>';
            }
        ?>
        </tbody>

    </table>

</div>


<?php
    // Include the footer file that contains
    // - javascript includes
    // - all closing tags corresponding to the opening tags in the header
    include 'partials/footer.php';
?>
