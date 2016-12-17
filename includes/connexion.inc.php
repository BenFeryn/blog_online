<?php

$connecte=FALSE;
if (isset($_COOKIE['sid'])&& !empty($_COOKIE['sid'])){
    $sid = $_COOKIE['sid'];
    $sth = $bdd->prepare($sql = "SELECT * FROM utilisateurs WHERE sid=:sid");
    $sth->bindValue(':sid', $sid, PDO::PARAM_STR);
    $sth->execute();
    $count = $sth->rowCount();
    
    if($count > 0){
        $connecte = TRUE;
    }
}

