<?php

// création du contenu du formulaire selon le tableau des champs (CHAMPS_FORMULAIRE)
function createFormContent($champs, $données): string
{
    $form_content = "";

    foreach ($champs as $champ) {
        $valeur_champ = checkForm($données, $champ);

        $form_content .= '<div>
            <label for="' . $champ['name'] . '">' . $champ['label'] . ' *</label>
            <input type="text" name="' . $champ['name'] . '" value="' . htmlspecialchars($valeur_champ) . '">
        </div>';
    }

    return $form_content;
}

// affichage du formulaire
function showForm($champs, $données): void
{
    echo '<form action="#" method="post">
        ' . createFormContent($champs, $données) . '
        <input type="submit" name="envoyer" value="Envoyer">
    </form>';
}

// vérification de la valeur de chaque champ
function checkForm($données, $champ): string
{
    $valeur_champ = isset($données[$champ['name']]) ? $données[$champ['name']] : '';

    return $valeur_champ;
}

// enregistrement des données dans le fichier txt
function saveUserData($données): void
{
    $fichierUtilisateur = fopen(DONNEES_UTILISATEUR, 'w');

    if (!$fichierUtilisateur) {
        throw new Exception('Le fichier n\' a pas pu être ouvert');
    }

    foreach ($données as $key => $value) {
        fputs($fichierUtilisateur, $value . "\n");
    }

    fclose($fichierUtilisateur);
}

// vérification de l'existence du fichier txt
function userDataExist(): bool
{
    return is_readable(DONNEES_UTILISATEUR);
}

// récupération des données enregistrées dans le fichier txt
function getUserData($champs): array
{
    $fichierUtilisateur = fopen(DONNEES_UTILISATEUR, 'r');

    $données = [];

    foreach ($champs as $champ) {
        $données += [$champ['name'] => fgets($fichierUtilisateur)];
    }

    fclose($fichierUtilisateur);

    return $données;
}
