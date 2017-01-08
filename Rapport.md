# Technologies Web: *Application PHP*

## Introduction

Notre application de réservation en ligne a été pensée et structurée de la façon la plus agréable et simple d'utilisation possible selon nous. Faisons le tour des différentes pages afin d'en expliquer l'utilisation.

![Page d'accueil](images/screen-index.png)

La première page comporte plusieurs éléments.
Tout d'abord intéressons nous au bouton **"Nouvelle réservation"**. Ce dernier comme son nom l'indique permet de créer une réservation et va donc rediriger vers une autre page où différentes informations seront demandées.

Nous avons ensuite un tableau où l'ensemble des réservations déjà effectuées précédemment est récapitulé. Chaque ligne de ce tableau indique la destination choisie, le numéro de la réservation, si une assurance annulation a été souscrite, un bouton de modification et un de suppression. Le premier renverra vers les mêmes pages que pour une nouvelle réservation, à l'exception qu'elles seront pré-remplies avec les valeurs propres à la réservation désirée. Le bouton de suppression, lui, supprimera de façon définitive la réservation (attention les passagers de cette réservation resteront eux en mémoire dans la base de données).

Les pages dont l'explication suit ne seront visibles que si le bouton "nouvelle réservation" ou un des boutons "modifier" a été enfoncé.

![Formulaire de réservation: Page 1](images/screen-form-1.png)

Dans la seconde page, trois champs demandent à être complété. Premièrement un nom de destination doit être saisi. Pour le moment toutes les destinations existe, une possibilité d'amélioration serait de restreindre le choix de l'utilisateur à une liste de destinations proposées.
Nous voyons ensuite un champ "assurance annulation". Ce champ va permettre de pouvoir annuler un voyage sans frais. Cette assurance n'est pas par défaut, il faut donc cocher la case pour la demander.
Il suffit ensuite d'indiquer le nombre de personnes participant au voyage et de passer à l'étape suivante en cliquant sur "suivant".

![Formulaire de réservation: Page 2](images/screen-form-2.png)


La troisième page sert à récolter les informations (nom et âge) propre à chaque passager. Il faut là entrer les informations demandées et cliquer sur "suivant".

![Formulaire de réservation: Page 3](images/screen-form-3.png)

La dernière page est un récapitulatif de l'ensemble de la réservation. Il devrait apparaitre sur cette page la destination avec/sans assurance et l'ensemble des passagers ainsi que leurs données propres. Pour valider la réservation cliquer sur "confirmer", vous serez ensuite automatiquement rediriger vers la page d'accueil où devrait maintenant apparaitre dans le tableau récapitulatif la réservation qui vient d'être réalisée.



## Structure du projet
La structure de notre code reflète bien le **pattern MVC** que nous avons utilisé pour ce projet, comme demandé dans l'énoncé. Nous pouvons retrouver un **contrôleur**, plusieurs **vues** et deux **modèles** dans notre projet.
```
.
├── index.php
├── controllers
│   └── app.php
├── css
│   └── style.css
├── LICENSE
├── models
│   ├── passenger.php
│   └── reservation.php
└── views
    ├── partials
    │   ├── footer.php
    │   └── header.php
    ├── reservation-form-0.php
    ├── reservation-form-1.php
    ├── reservation-form-2.php
    └── reservation-form-validated.php
```

### Contrôleur

Toutes les requêtes sont faites vers le fichier `index.php`, qui va démarrer la session et transférer la requête au contrôleur.

Le contrôleur, situé dans `controllers/app.php` est une classe contenant une seule méthode d'instance publique: `handle()`. Cette méthode va vérifier la présence, ou non, de certains paramètres envoyé avec la requête pour la dispatcher à une des méthodes internes qui s'occupera de faire les validations nécessaires et d'afficher la page adéquate.

Il est intéressant de noter que quand on affiche une des pages du formulaire, nous vérifions si les données ne sont pas déjà inscrites dans la session à l'aide de ce petit bout de code:

```php
<?php
if (isset($_SESSION['trip'])) {
    $trip = unserialize($_SESSION['trip']);
} else {
    $trip = new Reservation();
}
?>
```

Ceci permet de revenir en arrière dans le formulaire sans devoir remplir à nouveau les données préalablement fournies. Ça permet également de modifier des réservations avec le même formulaire simplement en les chargeant dans la session.

Pour déterminer quelle page afficher, le contrôleur vérifie premièrement la présence ou non de certains paramètres dans la requête `POST`. Ceci fonctionne pour nous puisque nous avons que quelques routes. Néanmoins, cette façon de faire devient très vite très compliqué quand on augmente le nombre de pages. C'est pour cela que de grands projets utilise des Framework qui offrent des capacités de routage. Si nous avions eu plus de routes, il aurait été fort intéressant de prendre le temps créer une abstraction gérant les routes.

Quand l'utilisateur appuie sur le bouton **"Nouvelle Réservation"**, le formulaire envoie une requête `POST` à l'`index.php` contenant un paramètre `new`. Quand la méthode `handle` du contrôleur voit la présence de ce paramètre, elle appelle la méthode privée `new` qui va inclure la vue `views/reservation-form-1.php`.

Une fois que l'utilisateur a rempli le formulaire, une nouvelle requête `POST` est envoyé à l'url `index.php`, cette fois-ci avec des paramètres différents. Cette fois-ci, c'est la méthode privée `step_1` qui est appelée. Un nouvel objet `Reservation` est crée si il n'existe pas déjà dans la session. Les champs du formulaire sont validés un par un, ceux qui sont valides sont mis à jour dans le modèle, pour les autres une entrée dans la table `$errors` est ajoutée. Une fois les champs validés, on sauvegarde le modèle mis à jour dans la session et deux possibilités se présentent:

1. Les champs étaient tous valides. Dans ce cas on avance tout simplement vers la prochaine partie du formulaire.
2. Un ou plusieurs champs n'étaient pas rempli correctement. Dans ce cas on renvoie vers le formulaire dont on vient en précisant les erreurs pour que la vue puisse afficher des erreurs à l'utilisateur.

La deuxième page du formulaire fonctionne de la même façon, à la différence près que le nombre de champs dans le formulaire est dynamique en fonction des valeurs précédemment entrées par l'utilisateur.

### Vues

Les vues sont des fichiers contenant majoritairement du code HTML augmenté par un peu de PHP pour afficher des informations dynamiques. Toutes les vues commencent par:

```php
<?php include 'partials/header.php'; ?>
```
et finissent avec:

```php
<?php include 'partials/footer.php'; ?>
```

Les morceaux de vues `header.php` et `footer.php` contiennent le code HTML commun entre toutes les vues. Il est toujours important d'éviter de répéter du code inutilement. Par ailleurs, extraire le code commun offre de gros avantages! On réduit le nombre de lignes nécessaires, certes. Mais le grand avantage se divulgue quand nous devons apporter une modification à ce code commun! En effet, si nous respectons le principe *DRY* la modification ne se fera que dans un fichier au lieu de tous les fichiers ou on aurait copié ce code.

Les vues ont accès au modèle pour afficher des informations à l'utilisateur. Il est fort important que la vue ne **modifie pas** le modèle directement. Toute modification du modèle doit impérativement passer par le contrôleur.


### Modèles

Les modèles sont des classes qui servent à représenter et manipuler les données. Ils peuvent fournir toute une pléthore de méthode permettant de les créer, modifier, sauvegarder ou supprimer. Par exemple, ce sont les modèles qui font le raccordement entre la base de données (stockage permanent) et le reste de l'application.

Dans notre application, nous avons seulement deux modèles: `Reservation` et `Passenger`. Le modèle `Passenger` est très minimale, il sert simplement à regrouper ensembles les propriétés d'un passager pour former une abstraction que le modèle `Reservation` va pouvoir utiliser au lieu de gérer les propriétés séparément. Le modèle pour les réservations est déjà plus conséquent, c'est le modèle que le contrôleur va accéder pour stocker et modifier les données. Il est normal alors que le modèle présente des méthodes pour réaliser ces modifications comme il se doit.

La communication avec la base de données ce fait également à partir du modèle `Reservation`. Celui-ci offre des méthodes d'instances, tel que `save`, qui permet d'écrire le modèle dans la base de données, mais également des méthodes de classe, tel que `list_reservations` qui permet de recevoir une liste de réservations présentes dans le système.
##### Protections contre les injections SQL

Une injection SQL survient souvent quand l'utilisateur prends astucieusement avantage du fait que son entrée est injecté directement dans le query SQL sans vérifications. Par exemple, imaginons la requête SQL suivante sans aucune vérification de ce que l'utilisateur entre comme nom:

```sql
SELECT uid FROM Users WHERE name = '(nom)' AND password = '(mot de passe haché)';
```

Il suffirait alors à l'utilisateur de fournir le nom `Dupont';--` et la requête prendrait une toute autre allure:

```sql
SELECT uid FROM Users WHERE name = 'Dupont'; -- ' AND password = '4e383a1918b432a9bb7702f086c56596e';
```

L'utilisateur peut donc se connecter avec n'importe quel mot de passe.

Pour palier à ce problème, nous utilisons des requêtes préparées qui sont compilé avant l'insertion des paramètres, ce qui les empêche d'être interprété. Par exemple, pour supprimer une réservation, nous avons la requête suivante:

```php
<?php
    $query = $mysqli->prepare('DELETE FROM avengers WHERE id = ?');
    $query->bind_param('i', $id);
    $query->execute();
    $query->close();
?>
```

Ceci évitera qu'un petit malin supprime toutes les réservations dans la base de données.







## Diagramme de séquence


![Diagramme de séquence vue client:](images/reservation_diag_seq.jpg)


##Conclusion





Plusieurs choses pourraient être le sujet de modification et de développement. Nous aurions en effet dut mieux commenter notre code par exemple. Celui-ci est en effet plutôt brut sans nécessairement beaucoup de commentaire pour aider à la compréhension. De plus une passe de nettoyage aurait été une bonne idée afin de réduire ou simplifier plusieurs méthodes. Nous avons effectivement modifier, retravailler et tester différentes façons de faire et n'avons pas toujours fait attention à tout simplifier et nettoyer.

D'un point de vue fonctionnel, nous n'avons pas choisi d'intégrer plusieurs interfaces. Chez nous tout est visible simplement et rapidement. Nous pouvons donc imaginer que notre site sera plutôt destiné à une agence de voyage où c'est un opérateur qui s'occupe de la réservation et non le voyageur. Pour permettre aux voyageurs de l'utiliser, il faudrait implémenter une interface spéciale où les voyages déjà réservés ne seraient pas accessibles sans mot de passe afin de protéger ces réservations.
Nous n'avons pas non plus implémenté de routine de calcul de prix. Ceci aurait pourtant été simple, mais n'avons pas eu le temps pour cela.


Les raisons pour lesquelles nous n'avons pas fait ces modifications sont simples, manque de temps et consigne par vague. Nous avons en effet reçu en deux semaines un très grand nombre de projets à rendre en un laps de temps assez cours. Difficile donc de pousser chaque projet jusqu'au bout, nous avons préféré rendre plusieurs bons projets plutôt que un excellent et plusieurs médiocres. La seconde raison est que ce site web a été construit pas à pas avec des objectifs finaux qui n’étaient pas tout à fait dans la même optique. Nous avons en effet du modifier un projet existant (faisant le sujet du travail précédent) pour ce site, et le modifier pour qu'il fasse l'affaire. La bonne solution qu'il aurait fallu faire aurait été de tout recommencer à zéro en s'inspirant du travail déjà fourni et non le modifier. Bien sûr cela aurait demandé un temps et des efforts supplémentaires que nous n'avions pas le luxe d'avoir.

Nous mettons donc en avant par ce projet qu'il faut toujours bien déterminé les attentes envers le produit final avant de commencer sa conception et se limiter à ce qui avait été décidé sans changer en cours de route d'avis sur ce que le résultat final doit faire.


## Code
##### index.php
```php
<?php
    session_start();
    include_once 'controllers/app.php';
    $app = new App();
    $app->handle();
```

##### controllers/app.php
```php
<?php

class App
{
    public function handle()
    {
        include_once 'models/reservation.php';
        include_once 'models/passenger.php';
        if (isset($_POST['new'])) {
            $this->new();
        } elseif (isset($_POST['step_1'])) {
            $this->step_1();
        } elseif (isset($_POST['step_2'], $_SESSION['trip'])) {
            $this->step_2();
        } elseif (isset($_POST['destroy'])) {
            $this->cancel();
        } elseif (isset($_POST['remove'])) {
            $id = $_POST['remove'];
            Reservation::remove($id);
            $this->home();
        } elseif (isset($_POST['edit'])) {
            $id = $_POST['edit'];
            $this->load_reservation_to_session($id);
            $this->new();
        } else {
            $this->home();
        }
    }

    private function home()
    {
        include 'views/reservation-form-0.php';
    }

    private function new($errors = null)
    {
        if (isset($_SESSION['trip'])) {
            $trip = unserialize($_SESSION['trip']);
        } else {
            $trip = null;
        }

        include 'views/reservation-form-1.php';
    }

    private function load_reservation_to_session($id)
    {
        $trip = Reservation::get($id);
        $_SESSION['trip'] = serialize($trip);
    }

    private function step_1($errors=null)
    {
        // Check if data is already in the session
        if (isset($_SESSION['trip'])) {
            $trip = unserialize($_SESSION['trip']);
        } else {
            $trip = new Reservation();
        }

        // If the errors variable is non null it means
        // we came from this form but had an error,
        // the POST parameters will not be set but
        // the session will contain an object
        if (empty($errors)) {
            $form_errors = array();

            if (empty($_POST['destination'])) {
                $form_errors['dest_set'] = false;
            } else {
                $target = $_POST['destination'];
                $trip->set_destination($target);
            }

            if (empty($_POST['places'])) {
                $form_errors['places_set'] = false;
            } elseif ($_POST['places'] <= 0) {
                $form_errors['places_pos'] = false;
            } else {
                $places = filter_var($_POST['places'], FILTER_VALIDATE_INT);
                $trip->set_n_passengers($places);
            }

            $insurance = isset($_POST['insurance']) ? (bool) $_POST['insurance'] : false;
            $trip->set_cancellation_insurance($insurance);

            $_SESSION['trip'] = serialize($trip);

            // If the validation failed
            if (!empty($form_errors)) {
                $this->new($form_errors);
                return;
            }
        }

        include 'views/reservation-form-2.php';
    }

    private function step_2()
    {
        // At this point there must be a trip object in
        // session, if not it's a bug...
        $trip = unserialize($_SESSION['trip']);

        $travellers = $_POST['traveller'];
        $ages = $_POST['age'];

        // Avoid douple passengers caused by add_passenger
        $trip->erase_passengers_DB();
        unset($trip->passengers);

        $form_errors = array();

        foreach ($travellers as $i => $traveller) {
            if (empty($traveller)) {
                $form_errors["t".$i] = false;
            }

            if (empty($ages[$i])) {
                $form_errors["a".$i] = false;
            }

            $trip->add_passenger(new passenger($traveller, $ages[$i]));
            //$age = $ages[$i];
        }

        $_SESSION['trip'] = serialize($trip);

        // If the validation failed
        if (!empty($form_errors)) {
            $this->step_1($form_errors);
            return;
        }

        $id_travel = $trip->get_id_travel();
        $destination = $trip->show_dest();
        $insurance_Bool = $trip->has_insurance();
        $insurance_T = $trip->case_insurance();
        $passengers = $trip->get_passengers();
        //save() sets all the detail of the reservation into our database 'avengers'
        $trip->save();
        /* As the id of the reservation is set in to save() routine, get_id_travel() needs
        to be called after save(). */
        $id_travel = $trip->get_id_travel();

        include 'views/reservation-form-validated.php';
    }

    private function cancel()
    {
        session_destroy();
        $this->home();
    }
}
```

##### models/reservation.php
```php
<?php

include_once 'passenger.php';

class Reservation
{
    private $id;
    private $destination;
    private $n_passengers = 0;
    private $cancellation_insurance = false;
    public $passengers = array();
    //private $id_travel = 0;
    private $mysqli;

    public function __construct(string $dest = null, bool $insurance = null, int $id = null)
    {
        if ($id != null) {
            $this->id = $id;
        }

        $this->destination = $dest;
        $this->cancellation_insurance = $insurance;
    }

    public function set_destination(string $dest)
    {
        $this->destination = $dest;
    }
    public function set_id_travel($value)
    {
        $this->id = $value;
    }

    public function get_destination()
    {
        return $this->destination;
    }

    public function set_n_passengers(int $n)
    {
        if (is_null($n)) {
            throw new Exception('Number of passengers is null');
        }
        $this->n_passengers = $n;
    }

    public function get_n_passengers()
    {
        return $this->n_passengers;
    }

    public function set_cancellation_insurance(bool $insurance)
    {
        if (is_bool($insurance)) {
            $this->cancellation_insurance = $insurance;
        } else {
            throw new Exception('Expected a boolean!');
        }
    }

    public function has_insurance()
    {
        return $this->cancellation_insurance;
    }

    public function add_passenger(Passenger $passenger)
    {
        $this->passengers[] = $passenger;
        if (count($this->passengers) > $this->n_passengers) {
            $this->n_passengers = count($this->passengers);
        }
    }

    public function get_passengers()
    {
        return $this->passengers;
    }

    public function show_dest()
    {
        return $this->destination;
    }

    public function case_insurance()
    {
        if ($this->cancellation_insurance == true) {
            return 'avec';
        } else {
            return 'sans';
        }
    }

    public function get_id_travel()
    {
        return $this->id;
    }

    public function load_data($id)
    {
        $this->mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        if ($this->mysqli->connect_errno) {
            echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
        }
        $load_Reserv = "SELECT * FROM avengers.avengers WHERE id ='$id'";

        $resultR = $this->mysqli->query($load_Reserv);

        $array = $resultR->fetch_array(MYSQLI_ASSOC);

        return $array;
    }

    public function load_people($id)
    {
        $this->mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        if ($this->mysqli->connect_errno) {
            echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
        }

        // FIXME: NOT GOOD --> SQL INJECTION RISK...
        $load_People = "SELECT * FROM avengers.peoples WHERE voyage =$id";
        $resultP = $this->mysqli->query($load_People);
        $posts = array();

        while ($row = $resultP->fetch_array()) {
            $ID = $row['id'];
            $name = $row['name'];
            $age = $row['age'];
            $voyage = $row['voyage'];

            $posts [] = array(
               'ID' => $ID,
               'name' => $name,
               'age' => $age,
               'voyage' => $voyage,
              );
        }

        return $posts;
    }

    public function save()
    {
        $this->mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        if ($this->mysqli->connect_errno) {
            echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
        }

        if ($this->id == null) {
            $sqlReserv = "INSERT INTO avengers.avengers(endroit, Cancel_Insurance)
        VALUES('$this->destination','$this->cancellation_insurance')";
            if ($this->mysqli->query($sqlReserv) == true) {
                //  echo 'Record updated successfully';
            $id_insert = $this->mysqli->insert_id;
                $this->id = $id_insert;
            } else {
                echo 'Error inserting record: '.$this->mysqli->error;
            }
        } else {

            //UPDATE `peoples` SET `name` = 'Mathieux', `age` = '23' WHERE `peoples`.`id` = 86;
            $query = $this->mysqli->prepare('UPDATE avengers SET endroit = ?, Cancel_Insurance = ? WHERE avengers.id = ?');
            $query->bind_param('sii', $this->destination, $this->cancellation_insurance, $this->id);

            if ($query->execute() == false) {
                echo 'Error inserting record: '.$this->mysqli->error;
            }

            $query->close();
        }

        foreach ($this->passengers as $i => $passenger) {
            //var_dump($passenger->return_id());
            if ($passenger->id == null) {
                $sqlPerson = "INSERT INTO avengers.peoples(name, age, voyage)
                VALUES('$passenger->name','$passenger->age','$this->id')";
                if ($this->mysqli->query($sqlPerson) == true) {
                    //echo 'Record updated successfully';
                } else {
                    echo 'Error inserting record: '.$this->mysqli->error;
                }
            } else {
                echo 'Updating'.$passenger->return_id();
                $p_id = $passenger->return_id();
                var_dump($p_id);
                //UPDATE `peoples` SET `name` = 'Mathieux', `age` = '23' WHERE `peoples`.`id` = 86;
                $query = $this->mysqli->prepare('UPDATE peoples SET name = ?, age = ? WHERE voyage = ?');
                $query->bind_param('sii', $passenger->name, $passenger->age, $this->id);

                if ($query->execute() == false) {
                    echo 'Error inserting record: '.$this->mysqli->error;
                }

                $query->close();
            }
        }
    }

    public static function list_reservations()
    {
        $mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        $query = $mysqli->prepare('SELECT * FROM avengers');
        $query->execute();
        $query->bind_result($id, $destination, $insurance);

        $reservations = array();

        while ($query->fetch()) {
            $reservations[] = ['id' => $id, 'destination' => $destination, 'insurance' => $insurance];
        }

        $query->close();

        return $reservations;
    }

    public static function remove($id)
    {
        $mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        $query = $mysqli->prepare('DELETE FROM avengers WHERE id = ?');
        $query->bind_param('i', $id);
        $query->execute();
        $query->close();
    }
    public function erase_passengers_DB()
    {
        $mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');
        foreach ($this->passengers as $i => $passenger) {
            $query = $mysqli->prepare('DELETE FROM avengers.peoples where voyage = ?');
            $query->bind_param('i', $this->id);
            $query->execute();
            $query->close();
        }
    }
    public static function get($trip_id)
    {
        $mysqli = new mysqli('localhost', 'user', 'password', 'avengers') or die('Could not select database');

        $query = $mysqli->prepare('SELECT * FROM avengers WHERE id = ?');
        $query->bind_param('i', $trip_id);
        $query->execute();
        $query->bind_result($id, $destination, $insurance);
        $query->fetch();
        $query->close();

        $reservation = new self($destination, $insurance, $id);

        $query = $mysqli->prepare('SELECT * FROM peoples WHERE voyage = ?');
        $query->bind_param('i', $trip_id);
        $query->execute();
        $query->bind_result($id, $name, $age, $reserv_id);

        while ($query->fetch()) {
            $passenger = new Passenger($name, $age, $id);
            $reservation->add_passenger($passenger);
        }

        $query->close();

        return $reservation;
    }
}
```

##### models/passenger.php
```php
<?php

class Passenger
{
    public $name;
    public $age;
    public $id = null;

    public function __construct($name, $age, $id = null)
    {
        $this->name = $name;
        $this->age = $age;
        if ($id != null) {
            $this->id = $id;
        }
    }

    public function return_id()
    {
        return $this->id;
    }
}
```

##### views/partials/header.php
```php
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Réservation</title>

        <!-- Load bootstrap 4 stylesheets and dependencies -->
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="node_modules/tether/dist/css/tether.min.css">
        <link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="css/style.css">

        <script src="node_modules/jquery/dist/jquery.min.js" charset="utf-8"></script>
    </head>
    <body>
      <div class="container">
```

##### views/partials/footer.php
```php
</div>

  <script src="node_modules/tether/dist/js/tether.min.js" charset="utf-8"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js" charset="utf-8"></script>
</body>

</html>
```

##### views/reservation-form-0.php
```php
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

                if ($res['insurance']) {
                    echo '<td class="text-xs-center">
                        <i class="fa fa-check"></i>
                    </td>';
                } else {
                    echo '<td class="text-xs-center">
                        <i class="fa fa-times"></i>
                    </td>';
                }

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
```

##### views/reservation-form-1.php
```php
<?php
// Include the header file that contains
// - the opening html tags
// - <head> tags with the necessary style and javascript includes
// - opening body tag and a bootstrap "container" div
include 'partials/header.php';
?>

<div id="step-1">

    <h1 class="row">Réservation</h1>

    <div class="row">

        <div class="jumbotron">
            <h3>Prix des places:</h3>
            <ul>
                <li>Moins de 12 ans = 10€</li>
                <li>Plus de 12 ans = 15€</li>
            </ul>
            Assurance annullation = 20 € peu importe le nombre de voyageurs.
        </div>
    </div>

    <form method="post" action="index.php">

        <?php
        $ds = isset($errors["dest_set"])? $errors["dest_set"] : true;
        $ps = isset($errors["places_set"])? $errors["places_set"] : true;
        $pp = isset($errors["places_pos"])? $errors["places_pos"] : true;
        ?>

        <div class="row">
            <div class="form-group col-md-6
            <?php if (!$ds) { echo 'has-warning'; } ?>
            ">
            <label for="destination">Destination</label>
            <input type="text" id="destination" name="destination"  class="form-control
            <?php if (!$ds) { echo 'form-control-warning'; } ?>
            "
            <?php
            if ($trip != null) {
                echo 'value="'.$trip->get_destination().'"';
            }?>/>
            <?php
            if (!$ds) {
                ?>
                <div class="form-control-feedback">Veuillez fournir une destionation.</div>
                <?php
            }
            ?>
        </div>

        <div class="form-group col-md-6
        <?php
        if (!$ps) { echo 'has-warning'; }
        elseif(!$pp) { echo 'has-danger'; }
        ?>
        ">
        <label for="places">Nombre de places</label>
        <input type="number" id="places" name="places" class="form-control
        <?php
        if (!$ds) { echo 'form-control-warning'; }
        elseif(!$pp) { echo 'form-control-danger'; }
        ?>"
        <?php
        if ($trip != null) {
            echo 'value="'.$trip->get_n_passengers().'"';
        }
        ?>/>
        <?php
        if (!$ds) {
            ?>
            <div class="form-control-feedback">Veuillez fournir un nombre de passagers.</div>
            <?php
        } elseif (!$pp) {
            ?>
            <div class="form-control-feedback">Le nombre de passagers doit être positif.</div>
            <?php
        }
        ?>
    </div>
</div>


<div class="form-check">
    <label class="form-check-label">
        <input type="checkbox" id="insurance" name="insurance" value="valeur" class="form-check-input"
        <?php if ($trip != null && $trip->has_insurance()) {
            echo 'checked';
        }?> />
        Assurance annullation
    </label>
</div>


<button type="submit" class="btn btn-primary" name="step_1">Suivant</button>
<button name="destroy" class="btn btn-default">Annulation</button>


</form>

<div class="stepwizard">
    <div class="stepwizard-row">
        <div class="stepwizard-step">
            <button type="button" class="btn btn-primary btn-circle">1</button>
            <p>Destination</p>
        </div>
        <div class="stepwizard-step">
            <button type="button" class="btn btn-default btn-circle" disabled="disabled">2</button>
            <p>Détails de réservation</p>
        </div>
        <div class="stepwizard-step">
            <button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
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
```

##### views/reservation-form-2.php
```php
<?php
  include 'partials/header.php';
 ?>

<div id="step-2">

      <h1 class="row">Détails de réservation</h1>

      <div class="jumbotron container">
          <h3>Récapitulatif</h3>
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
      </div>

      <form method="post" action="index.php">


          <div class="row">

          <?php
          //creating a dictionnary people
          $people = array(); //doesn't work
          for ($i = 0; $i < (int) $trip->get_n_passengers(); ++$i) {

              $ts = isset($errors["t".$i])? $errors["t".$i] : true;
              $as = isset($errors["a".$i])? $errors["a".$i] : true;
              ?>

              <div class="col-md-4 passenger">

                  <h5>Voyageur #<?php echo $i + 1; ?> </h4>
                  <div class="form-group
                  <?php if (!$ts) { echo 'has-warning'; } ?>
                  ">
                      <label for="traveller">Nom</label>
                      <input name="traveller[]" type="text" placeholder="Voyageur" class="form-control
                      <?php if (!$ts) { echo 'form-control-warning'; } ?>"
                      <?php
                        if (array_key_exists($i, $trip->passengers)) {
                            echo 'value="'.$trip->passengers[$i]->name.'"';
                        } ?>
                      />
                  </div>
                  <div class="form-group
                  <?php if (!$as) { echo 'has-warning'; } ?>
                  ">
                      <label for="age">Age</label>
                      <input name="age[]" type="text" placeholder="Age" class="form-control
                      <?php if (!$ts) { echo 'form-control-warning'; } ?>"
                      "
                      <?php  if (array_key_exists($i, $trip->passengers)) {
                            echo 'value="'.$trip->passengers[$i]->age.'"';
                        } ?>/>
                  </div>
              </div>
              <?php

          } ?>
          </div>

          <div class="row">
              <div class="form-group col-md-12">
                  <button name="step_2" class="btn btn-primary" name = "Submit">Suivant</button>
                  <button name="destroy" class="btn btn-default">Annulation</button>
              </div>
          </div>
      </form>

      <div class="stepwizard">
          <div class="stepwizard-row">
              <div class="stepwizard-step">
                  <button type="button" class="btn btn-default btn-circle">1</button>
                  <p>Destination</p>
              </div>
              <div class="stepwizard-step">
                  <button type="button" class="btn btn-primary btn-circle">2</button>
                  <p>Détails de réservation</p>
              </div>
              <div class="stepwizard-step">
                  <button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
                  <p>Confirmation</p>
              </div>
          </div>
      </div>

</div>

<?php
  include 'partials/footer.php';
?>
```

##### views/reservation-form-validated.php
```php
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
            Voici une récapitulation de votre réservation.<br>
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
            <button name="destroy" class="btn btn-primary btn-lg">Confirmer</button>
            <button name="destroy" class="btn btn-default btn-lg">Anuller</button>
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
```
