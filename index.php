<?php

require_once './constants.php';
require_once './util.php';

$données = [];

if (isset($_POST['envoyer'])) {
    // on ajoute les informations reçues depuis le formulaire dans le tableau $données
    foreach ($_POST as $key => $value) {
        if (!empty($value)) {
            if ($key === "envoyer") continue;
            $données += [$key => $value];
        }
    }
    /* si tous les champs sont remplis
    on sauvegarde les données dans le fichier txt prévu à cet effet
    on affiche un message de succès ou d'erreur */
    if (count($données) === count($_POST) - 1) {
        saveUserData($données);
        echo '<p style="color: green">Vos données ont bien été envoyées</p>';
    } else {
        echo '<p style="color: red">Vous devez renseigner tous les champs</p>';
    }
}

// on récupère les données enregistrées dans le fichier txt
if (userDataExist()) {
    $données = getUserData(CHAMPS_FORMULAIRE);
}

// on affiche le formulaire
showForm(CHAMPS_FORMULAIRE, $données);
