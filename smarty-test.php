<?php

require_once('libs/Smarty.class.php');

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

$name = "Benjamin";
$smarty->assign('name',$name); //assigne une variable php à smarty (nom + valeur)

//** un-comment the following line to show the debug console
$smarty->debugging = true;

$smarty->display('smarty-test.tpl');

?>