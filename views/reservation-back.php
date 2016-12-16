<?php
    // Include the header file that contains
    // - the opening html tags
    // - <head> tags with the necessary style and javascript includes
    // - opening body tag and a bootstrap "container" div
    include 'partials/header.php';
?>
<h1> Voyage vers: </h1>

<?php echo 'Destination actuelle: '.$destination.'<br>'; ?>
<form method="post" action="index.php">
<div class="row">
    <p> <input name="modif" type="text" placeholder="<?php echo $destination ?>" /></p>
    <br>
    <button type="submit" class="btn btn-default btn-lg" name="Update">Modifier la destination </button>
</div>
</form>

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

    <div class="form-group row">
        <input name="Delete_P" type="text" placeholder="Numéros du voyageur" />
    </div>
    <button type="submit" class="btn btn-defalut btn-lg" name="delete">Supprimer ce voyageur: </button>
</div>
<br>
</form>
<form method="post" action="index.php">
<div class="row">

    <p> Nom: <input name="traveller" type="text" placeholder="Nom Prénom" /></p>
    <p> Age: <input name="age" type="text" placeholder="Age" /></p>
    <button type="submit" class="btn btn-default btn-lg" name="add">Ajouter ce voyageur: </button>
<br>
<br>
    <button type="submit" class="btn btn-primary btn-lg" name="Done">Mettre votre réservation à jour</button>
</div>
</form>









<?php
    // Include the footer file that contains
    // - javascript includes
    // - all closing tags corresponding to the opening tags in the header
    include 'partials/footer.php';
?>
