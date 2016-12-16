<?php
    // Include the header file that contains
    // - the opening html tags
    // - <head> tags with the necessary style and javascript includes
    // - opening body tag and a bootstrap "container" div
    include 'partials/header.php';
?>
<h1> Voyage vers: </h1>

<?php echo 'Destination actuelle: '.$destination.'<br>'; ?>
<div class="form-group row">
    <input type="text" id="destination" name="destination" placeholder="Nouvelle Destination" class="form-control" />
</div>

<?php echo 'Votre voyage se passe actuellement '.$assurance.' assurance annulation.'.'<br>'?>
<div class="form-check row">
    <label class="form-check-label">
        <input type="checkbox" id="insurance" name="insurance" value="valeur" class="form-check-input" />
        Assurance annulation.
    </label>
</div>
<?php echo 'Vos passagers sont:';

foreach ($ptisCons as $i) {
    echo '<br>'.$i['name'].' '.$i['age'].' voyageur numeros '.$i['ID'];
}
?>
<br>
<br>
<h5> Gestion des voyageurs: </h5>
<form method="post" action="index.php">
<div class="row">
    <button type="submit" class="btn btn-defalut btn-lg" name="delete">Supprimer ce voyageur: </button>
    <div class="form-group row">
        <input name="Delete_P" type="text" placeholder="Numéros du voyageur" />
    </div>
</div>
</form>
<form method="post" action="index.php">
<div class="row">

    <p> Nom: <input name="traveller" type="text" placeholder="Voyageur" /></p>
    <p> Age: <input name="age" type="text" placeholder="Age" /></p>
    <button type="submit" class="btn btn-default btn-lg" name="add">Ajouter ce voyageur: </button>
</div>
</form>
<br>
<br>
<form method="post" action="index.php">
<div class="row">
    <button type="submit" class="btn btn-primary btn-lg" name="Update">Mettre votre réservation à jour</button>
</div>
</form>









<?php
    // Include the footer file that contains
    // - javascript includes
    // - all closing tags corresponding to the opening tags in the header
    include 'partials/footer.php';
?>
