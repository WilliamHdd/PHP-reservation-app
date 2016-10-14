<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Détails de réservation:</title>
        <link rel="stylesheet" href="css/style.css">

        <!-- Load bootstrap 4 stylesheets and dependencies -->
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="node_modules/tether/dist/css/tether.min.css">
        <script src="node_modules/jquery/dist/jquery.min.js" charset="utf-8"></script>

    </head>
    <body>
      <h1>Détails de réservation:</h1>
      <p> Voyage vers <?php echo $_session["destination"],":"; ?> </p>
      <?php
      if(isset($_session['insurance']))
      {
        echo "Avec assurance annulation.<br><br>";
      }
      else
      {
        echo "Sans assurance annulation.<br><br>";
      }

      ?>
      <form method="post" action="step_2.php">
      <?php
      //creating a dictionnary people
      $people = array();//doesn't work

      for ($i = 1  ;$i < (int)$_POST['places'] + 1; $i ++)
      {
        echo "Voyageur ", $i;
        //ini_set('display_errors', 1);
        //ini_set('display_startup_errors', 1);
        //error_reporting(E_ALL);
        ?>

        <p> Nom: <input name = "travellor" type="text" placeholder="Voyageur " /></p>

        <p> Age: <input name = "age" type="text" placeholder="Age" /></p>
        <?php
        $travellor = $_session['travellor'];//doesn't work
        $age = $_session['age'];//doesn't work
        // Adding to $people the travellor's id and age
        $people[$travellor] = $age;//doesn't work
         ?>
      <?php } ?>

      <p>
        <button name="step_2" class="btn btn-primary btn-lg" name = "Submit">Suivant</button>
        <button name="destroy_2" class="btn btn-default btn-lg">Annulation</button>
      </p>
      </form>

      <script src="node_modules/bootstrap/dist/js/bootstrap.min.js" charset="utf-8"></script>
      <script src="node_modules/tether/dist/js/tether.min.js" charset="utf-8"></script>

      </body>
</html>
