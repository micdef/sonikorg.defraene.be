<?php

	//******************************************************************************
    //*                                                                            *
    //* PARTIE 0 : HEADERS PHP		                                               *
    //*                                                                            *
    //******************************************************************************
	// N/A

	//******************************************************************************
    //*                                                                            *
    //* PARTIE 1 : FICHIERS A INCLURE                                              *
    //*                                                                            *
    //******************************************************************************
    include_once '../classes/usr_user.php';
	include_once '../inc/token.inc';
	
	//******************************************************************************
    //*                                                                            *
    //* PARTIE 2 : DECLARATION DES VARIABLES GLOBALES                              *
    //*                                                                            *
    //******************************************************************************
	// N/A

	//******************************************************************************
    //*                                                                            *
    //* PARTIE 3 : MISE EN PLACE DES VALEURS DES VARIABLES GLOBALES                *
    //*                                                                            *
    //******************************************************************************
	// N/A
	
	//******************************************************************************
    //*                                                                            *
    //* PARTIE 4 : EXECUTION DU RPC                								   *
    //*                                                                            *
    //******************************************************************************
	
	// Vérification de l'environnement
	if ($_GET["env"] == "DEV") {
		
		// Gestion des erreurs coté Serveur
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}
	
	// Démarrage de la session
	session_start();

	// Mise en place de l'utilisateur guest
	$_SESSION["email"] = "webmaster@defraene.be";
	$guest = new User();
	$guest->newGuest();
	$_SESSION["email"] = $guest->getEmail();
	$_SESSION["user"] = $guest;
	createToken($guest, "CKGST", null, (time() + (8 * 3600)));
	$_SESSION["logged"] = false;
	$_SESSION["lang"] = "fr-fr";
	$_SESSION["token"] = getIDToken("CKGST", $guest);

	// Retour du RPC
	echo session_id();

?>