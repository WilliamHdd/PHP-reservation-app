<?php
    // Include the header file that contains
    // - the opening html tags
    // - <head> tags with the necessary style and javascript includes
    // - opening body tag and a bootstrap "container" div
    include("partials/header.php");
?>

<h1> Toute l'équipe vous remercie de votre réservation!</h1>
<p> À bientot!<p>
<form method="post" action="index.php">
    <button name="destroy_3" class="btn btn-primary btn-lg">Y'a pas de quoi.</button>
</form>

<?php
    // Include the footer file that contains
    // - javascript includes
    // - all closing tags corresponding to the opening tags in the header
    include("partials/footer.php");
?>
