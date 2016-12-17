<?php

session_start();

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
require_once 'includes/connexion.inc.php';
require_once 'libs/Smarty.class.php';
if ($connecte == FALSE) {
    $_SESSION['erreurdeco'] = TRUE;
    header('Location: http://benferyn.esy.es/index.php');
}
if (isset($_GET['id'])) { // s'il y a un ID dans l'URL
    $monid = $_GET['id'];   // variable permettant de stocker l'id même si l'url change
    $sth = $bdd->prepare("SELECT id,titre,texte, DATE_FORMAT(date,'%d/%m/%Y') as date_fr FROM articles WHERE id = $monid");
    $sth->execute(); //execute la commande
    $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);

    $titrechamps = $tab_articles[0]['titre'];
    $textechamps = $tab_articles[0]['texte'];
    $bouton = "modifier";
    $checkbox = "checked";
} else { // s'il n'y a pas d'ID dans l'URL
    //include_once 'include/header.inc.php';
    $tab_articles = null;
    $titrechamps = "";
    $textechamps = "";
    $bouton = "ajouter";
    $checkbox = "";
    $monid = "";
}

// QUAND ON CLIQUE SUR FORM ET VALEUR = AJOUTER       
if (isset($_POST['ajouter'])) {
    //print_r($_FILES);
    $date_ajout = date("Y-m-d"); // creation de la date
    $_POST['date'] = $date_ajout; //ajoute la date dans l'array du formulaire
    //condition ternaire
    $_POST['publie'] = isset($_POST['publie']) ? 1 : 0;

    //print_r($_POST);
    if ($_FILES['image']['error'] == 0) {
        ///SECURISE LES VARIABLES
        $sth = $bdd->prepare("INSERT INTO articles (titre,texte,date,publie) VALUES (:titre,:texte,:date,:publie)");
        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
        $sth->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
        $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_BOOL);

        $sth->execute(); //execute la commande
        $id = $bdd->lastInsertId();
        //echo $dernier_id;
        move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$id.jpg");

        $_SESSION['ajout_article'] = TRUE;
    } else {
        echo "image erreur";
    }
}
// QUAND ON APPUIE SUR LE BOUTON MODIFIER
if (isset($_POST['modifier'])) {
    $idfixe = $_POST['id']; // id "caché" de l'article en cours de modif
    $sth = $bdd->prepare("UPDATE articles SET titre=:titre, texte=:texte WHERE id= $idfixe");
    $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
    $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);

    $sth->execute(); //execute la commande
    $_SESSION['modifier_article'] = TRUE;
    header('Location: article.php');
} else {  //SANS CE ELSE LES NOTIFICATIONS NE FONCTIONNENT PAS
    //----------- PARTIE SMARTY --------------------//
    //----------- Création et initialisation de l'objet smarty-----------//
    $smarty = new Smarty();

    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');
    //$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
    //$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
    
    // ------- TRAITEMENT MODIFICATIONS -------------//
    if (isset($_SESSION['ajout_article'])) {
        $smarty->assign('ajout_article', $_SESSION['ajout_article']);
    }
    unset($_SESSION['ajout_article']);

    if (isset($_SESSION['modifier_article'])) {
        $smarty->assign('modifier_article', $_SESSION['modifier_article']);
    }
    unset($_SESSION['modifier_article']);

    //------------ CREATION DES VARIABLES SMARTY ---------------//
    $smarty->assign('tab_articles', $tab_articles);
    $smarty->assign('checkbox', $checkbox);
    $smarty->assign('bouton', $bouton);

    //$smarty->debugging = true;
    //--------------- FORMAT DE LA PAGE ------------ //
    include_once 'includes/header.inc.php';
    $smarty->display('article.tpl');
    include_once 'includes/menu.inc.php';
    include_once 'includes/footer.inc.php';
}