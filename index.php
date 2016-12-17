<?php

session_start();
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/connexion.inc.php';
require_once 'libs/Smarty.class.php';

// -------- Quelques valeurs pour la pagination -------------- //
$nbarticlespage = 2;

$pagecourante = isset($_GET['p']) ? $_GET['p'] : 1;
$premierarticle = ($pagecourante - 1) * $nbarticlespage;

// ---------- REQUETE SQL COMPTER LES ARTICLES ------------- //
$sth = $bdd->prepare("SELECT COUNT(*) as nbArticles FROM articles WHERE publie=:publie");
$sth->bindValue(':publie', 1, PDO::PARAM_INT);
$sth->execute();
$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);

$nbarticles = $tab_articles[0]['nbArticles'];


$nbpagetotal = ceil($nbarticles / $nbarticlespage);

// ------------------ REQUETE SQL : AFFICHER LES ARTICLES ----------------------------//
// -------LE ORDRE BY SERT A AFFICHER LE DERNIER ARTICLE EN PREMIER --------------- //
$sth = $bdd->prepare("SELECT id,titre,texte, DATE_FORMAT(date,'%d/%m/%Y') as date_fr FROM articles WHERE publie = :publie ORDER BY id DESC LIMIT $premierarticle, $nbarticlespage");
$sth->bindValue(':publie', 1, PDO::PARAM_INT); //permet de securiser le publie
$sth->execute(); //execute la commande

$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);

// ---------------- ----ENVOYER LE COMMENTAIRE --------------------------- //
if (isset($_POST['envoyer'])) {
    $sth = $bdd->prepare("INSERT INTO commentaire (mail,pseudo,commentaire,id_article) VALUES (:mail,:pseudo,:commentaire,:id_article)"); //requete SQL permettant de mettre a jour les champs de la BDD
    $sth->bindValue(':mail', $_POST['email'], PDO::PARAM_STR);
    $sth->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $sth->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
    $sth->bindValue(':id_article', $_POST['id_article'], PDO::PARAM_STR); //valeur de id_article fausse

    $sth->execute(); //execute la commande

    $_SESSION['notif_com'] = TRUE;
    header('Location: index.php');
}

// ------------- SI ON A UN COM DANS L'URL ----------------- //
if (isset($_GET['com'])) {
    $idcommentaire = $_GET['com'];
    
    // AFFICHE LES COMMENTAIRES
    $sth = $bdd->prepare("SELECT * FROM articles,commentaire WHERE articles.id=commentaire.id_article AND articles.id=$idcommentaire ORDER BY commentaire.id DESC LIMIT $premierarticle,$nbarticlespage");
    $sth->execute(); //execute la commande
    $tab_recherches = $sth->fetchAll(PDO::FETCH_ASSOC);
    
    // -------REQUETE POUR COMPTER LES COMMENTAIRES  --------------- //
    $sth = $bdd->prepare("SELECT * FROM articles,commentaire WHERE articles.id=commentaire.id_article AND articles.id=$idcommentaire");
    $sth->execute(); //execute la commande
    $count = $sth->rowCount(); //compte le nbre de ligne dans le résultat de la requête
    
    // ------------ SI AUCUN COMMENTAIRE ---------------- //
    if ($count == 0) {
        // sans la requete suivant extremement similaire à l'affichage des articles, on ne sait pas quel article afficher
        // cette requete permet juste de récupérer l'id dans l'URL de l'article et d'afficher les renseignements correspondant.
        $sth = $bdd->prepare("SELECT articles.id,titre,texte, DATE_FORMAT(date,'%d/%m/%Y') as date_fr FROM articles,commentaire WHERE articles.id=$idcommentaire");
        $sth->bindValue(':publie', 1, PDO::PARAM_INT); //permet de securiser le publie
        $sth->execute(); //execute la commande
        $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        // ---------------- PARTIE SMARTY ----------------- //
        $smarty = new Smarty();

        $smarty->setTemplateDir('templates/');
        $smarty->setCompileDir('templates_c/');
        //$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
        //$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
        
    //----------- VARIABLES SMARTY -----------------//
        
        $smarty->assign('idcommentaire', $idcommentaire);
        $smarty->assign('tab_articles', $tab_articles);
        $smarty->assign('count', $count);

        include_once 'includes/header.inc.php';
        $smarty->display('index.tpl');
        include_once 'includes/menu.inc.php';
        include_once 'includes/footer.inc.php';

        //S'IL Y A UN COMMENTAIRE SUR L'ARTICLE
    } else {
        
        $nbarticlespage = 2;

        $pagecourante = isset($_GET['p']) ? $_GET['p'] : 1;
        $premierarticle = ($pagecourante - 1) * $nbarticlespage;
        $nbpagetotal = ceil($count / $nbarticlespage); //nombre de page(s) pour la recherche
        
        $smarty = new Smarty();

        $smarty->setTemplateDir('templates/');
        $smarty->setCompileDir('templates_c/');
        //$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
        //$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
        //----------- VARIABLES SMARTY -----------------//
        
        $smarty->assign('idcommentaire', $idcommentaire);
        $smarty->assign('tab_recherches', $tab_recherches);
        $smarty->assign('tab_articles', $tab_articles);
        $smarty->assign('count', $count);
        $smarty->assign('pagecourante',$pagecourante);
        $smarty->assign('nbpagetotal',$nbpagetotal);
        $smarty->assign('nbarticlespage',$nbarticlespage);

        include_once 'includes/header.inc.php';
        $smarty->display('index.tpl');
        include_once 'includes/menu.inc.php';
        include_once 'includes/footer.inc.php';
    }

    // ARRIVE SUR LA PAGE D'ACCEUIL
} else {

// -------------- PARTIE SMARTY --------------------- //
    $smarty = new Smarty();

    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

// ------------- VARIABLES SMARTY ---------------- //
    if (isset($_SESSION['cookie'])) {
        $smarty->assign('cookie', $_SESSION['cookie']);
    }
    unset($_SESSION['cookie']);

    if (isset($_SESSION['deconnexion'])) {
        $smarty->assign('deconnexion', $_SESSION['deconnexion']);
    }
    unset($_SESSION['deconnexion']);

    if (isset($_SESSION['erreurdeco'])) {
        $smarty->assign('erreurdeco', $_SESSION['erreurdeco']);
    }
    unset($_SESSION['erreurdeco']);

    $smarty->assign('tab_articles', $tab_articles);
    $smarty->assign('connecte', $connecte);
    $smarty->assign('nbpagetotal', $nbpagetotal);

// ---------- MISE EN PAGE ------------ //
    include_once 'includes/header.inc.php';
    $smarty->display('index.tpl');
    include_once 'includes/menu.inc.php';
    include_once 'includes/footer.inc.php';
}
