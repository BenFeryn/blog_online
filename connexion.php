<?php
    session_start();
    
    include_once 'includes/connexion.inc.php';
    require_once 'settings/bdd.inc.php';
    require_once 'settings/init.inc.php';
    require_once 'libs/Smarty.class.php';
    
// SI ON APPUIE SUR LE BOUTON CONNECTER
if (isset($_POST['connecter'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    
    $sql = "SELECT * FROM utilisateurs WHERE email= :email AND mdp= :mdp";
    $sth = $bdd->prepare($sql = "SELECT * FROM utilisateurs WHERE email= :email AND mdp= :mdp");
    $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $sth->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);

    $sth->execute();
    $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
    

    $sid = md5($email.  time());
    $count = $sth->rowCount(); //compte le nbre de ligne dans le résultat de la requête
    
    // SI LES LOGS SONT CORRECTES
    if ($count >=1){
    
    $monid = $tab_articles[0]['id'];
    $sth = $bdd->prepare("UPDATE utilisateurs SET sid=:sid WHERE id=$monid");
    $sth->bindValue(':sid', $sid, PDO::PARAM_STR);

    $sth->execute(); //execute la commande
    setcookie('sid', $sid, time() + 3600*24);
    $_SESSION['cookie'] = TRUE;
  
    header('Location:index.php');
    }
    else {
        $_SESSION['unlucky']=TRUE;
        header('Location:connexion.php');
    }
}else{
// ------ PARTIE SMARTY ----------- //
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

if(isset($_SESSION['unlucky'])){
$smarty->assign('unlucky',$_SESSION['unlucky']);
}
unset($_SESSION['unlucky']);
//** un-comment the following line to show the debug console
//$smarty->debugging = true;
include_once 'includes/header.inc.php';
$smarty->display('connexion.tpl');

include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';
}
