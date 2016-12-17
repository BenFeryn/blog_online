<?php

session_start();
setcookie('sid','',1);
$_SESSION['deconnexion'] = TRUE;
header('Location: index.php');

