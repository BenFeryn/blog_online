<?php

session_start();
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/connexion.inc.php';

if ($connecte == FALSE) {
    $_SESSION['erreurdeco'] = TRUE;
    header('Location: Index.php');
}else{

	if (isset($_GET['id'])) { // s'il y a un ID dans l'URL
	    $monid = $_GET['id'];   // variable permettant de stocker l'id même si l'url change
	    $sth = $bdd->prepare("DELETE FROM commentaire WHERE id_article = $monid");
	    $sth->execute(); //execute la commande
	    $sth = $bdd->prepare("DELETE FROM articles WHERE id = $monid");
	    $sth->execute(); //execute la commande
	    
	    header('Location: index.php');
	}
}

