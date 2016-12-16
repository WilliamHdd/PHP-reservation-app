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
                <button id="new-reservation" type="submit" class="btn btn-primary" name="new">
                    Nouvelle réservation
                </button>
            </form>
        </div>

        <div class="col-md-6">
            <form method="post" action="index.php" class="container">
                <button id="old-reservations" type="submit" class="btn btn-primary" name="old">
                    Accéder à une réservation
                </button>
            </form>
        </div>
    </div>
</div>

<?php
    // Include the footer file that contains
    // - javascript includes
    // - all closing tags corresponding to the opening tags in the header
    include 'partials/footer.php';
?>
