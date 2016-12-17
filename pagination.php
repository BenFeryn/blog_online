<?php
session_start();

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';

/*Résulat : echo page courante, Index de départ, index d'arrivée


déclarer une variable qui contient le nbre article à afficher par page (2)

Variable qui contient la page courante (GET)


Calculer l'index de départ de la requete ((page courante - 1) *2)?>

Calculer le nbre de message publié dans la table */
$nbarticlespage = 2;

$pagecourante = isset($_GET['p']) ? $_GET['p']:1;
$premierarticle = ($pagecourante -1) *$nbarticlespage;
$nbpagetotal = ceil($nbarticles / $nbarticlespage);
$nbarticles = $tab_articles[0]['nbArticles'];

$sth=$bdd->prepare("SELECT COUNT(*) as nbArticles FROM articles WHERE publie=:publie LIMIT $premierarticle, $nbarticlespage");
$sth->bindValue(':publie', 1, PDO::PARAM_INT);
$sth->execute();

$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
//print_r($tab_articles);

echo "la page courante est : ".$pagecourante;
?>
<br>
<?php
echo "le premier article est : ".$premierarticle;
?>
<br>
<?php
echo "le nombre de pages total est de : ".$nbpagetotal;
?>
<br>
<?php
echo "pages :";
for ($pages = 1; $pages <= $nbpagetotal; $pages++) {
    echo '<a href="pagination.php?p='.$pages . '">' .$pages. " ".'</a>';
}

?>