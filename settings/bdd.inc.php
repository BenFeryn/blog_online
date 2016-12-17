<?php

try{
    $bdd = new PDO('mysql:host=localhost;dbname=u274311870_feryn;charset=utf8','u274311870_feryn','azertykpl59180');
    $bdd->exec("set names utf8");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e) {
    die('Erreur :'.$e->getMessage());
}