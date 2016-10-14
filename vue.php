<!DOCTYPE html>
<html>
    <head>
      Détails de réservation:
    </head>
    <body>
      <p> Voyage vers <?php echo $_session["destination"]; ?> </p>
      <?php for ($i = (int)$_POST['places'] ;$i > 0; $i --)
      {
        echo "Voyageur" ;
        //ini_set('display_errors', 1);
        //ini_set('display_startup_errors', 1);
        //error_reporting(E_ALL);
        ?>
      <form method="post">
        <p> Nom: <input type="text" placeholder="Voyageur " /></p>
        <p> Age: <input type="text" placeholder="Age" /></p>
      </form>
      <?php } ?>
      <input type="button" value="Clic !" /><input type="button" value="Clic !" /><input type="button" value="Clic !" />
    </body>
</html>
