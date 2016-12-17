<?php

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/connexion.inc.php';
require_once 'libs/Smarty.class.php';

// ------------- PAGINATION RECHERCHE ------------------- //
$nbarticlespage = 2;

$pagecourante = isset($_GET['p']) ? $_GET['p'] : 1;
$premierarticle = ($pagecourante - 1) * $nbarticlespage;


//  ---------------- RESULTAT DE LA RECHERCHE ---------------------- //
$recherche = $_GET['recherche'];
$sth = $bdd->prepare("SELECT id,titre,texte, DATE_FORMAT(date,'%d/%m/%Y') as date_fr FROM articles WHERE (titre LIKE :recherche OR texte LIKE :recherche)ORDER BY id DESC");
$sth->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
$sth->execute();
$count = $sth->rowCount(); //compte le nbre de ligne(s) dans le résultat de la requête
$nbpagetotal = ceil($count / $nbarticlespage); //nombre de page(s) pour la recherche

// --------------- Nombre de résultats de la recherche  permet de faire la pagination------------------ //
$sth = $bdd->prepare("SELECT id,titre,texte, DATE_FORMAT(date,'%d/%m/%Y') as date_fr FROM articles WHERE (titre LIKE :recherche OR texte LIKE :recherche)ORDER BY id DESC LIMIT $premierarticle,$nbarticlespage");
$sth->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
$sth->execute();

if ($count > 0) {
    $tab_recherches = $sth->fetchAll(PDO::FETCH_ASSOC);
} else {
    $tab_recherches = null;
}
// ------------- PAGINATION RECHERCHE ------------------- //
$nbarticlespage = 2;

$pagecourante = isset($_GET['p']) ? $_GET['p'] : 1;
$premierarticle = ($pagecourante - 1) * $nbarticlespage;

// -------------- PARTIE SMARTY --------------------- //
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');


// ------------- VARIABLES SMARTY ---------------- //
$smarty->assign('connecte',$connecte);
$smarty->assign('tab_recherches', $tab_recherches);
$smarty->assign('count', $count);
$smarty->assign('pagecourante',$pagecourante);
$smarty->assign('nbpagetotal',$nbpagetotal);
$smarty->assign('recherche', $recherche);

// ---------- MISE EN PAGE ------------ //
include_once 'includes/header.inc.php';
$smarty->display('research.tpl');
include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';