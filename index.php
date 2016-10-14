<!DOCTYPE html>
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
        <h1>Réservation</h1>

        <p>  Prix des places: </p>
        <p> Moins de 12 ans = 10€ </p>
        <p> Plus de 12 ans = 15€ </p>
        <p> Assurance reservation = 20 € peu important le nombre de voyageurs. </p>


        <article>
          <p> Destination: <input type="text" value="Destination" /> </p>
          <p> Nombre de places:<input type="number" /> </p>
          <p> Assurance annulation? <input type="checkbox" value="valeur" /> </p>
        </article>
        <input type="button" value="Etape suivante" /><input type="button" value="Annulation" />

        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js" charset="utf-8"></script>
        <script src="node_modules/tether/dist/js/tether.min.js" charset="utf-8"></script>
    </body>
</html>
