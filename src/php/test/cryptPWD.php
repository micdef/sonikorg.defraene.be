<?php

	// Gestion des erreurs coté Serveur
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Inclusion des fichiers
	include_once('../inc/crypt.inc');

	// Cryptage du mot de passe
	$test = $_GET["test"];
	echo encrypt($_GET["test"]);
?>