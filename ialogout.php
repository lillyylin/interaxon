#!/usr/local/bin/php
<?php
session_start();


$_SESSION['loggedin'] = false;
$_SESSION['usrconfirm'] = false;
header('Location: interaxon.php');
?>