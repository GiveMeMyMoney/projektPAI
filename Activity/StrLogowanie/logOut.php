<?php
session_start();

session_unset();

$_SESSION['zalogowany'] = false; //flaga
unset($_SESSION['zalogowany']);
unset($_SESSION['id_uzytkownika']);
unset($_SESSION['uzytkownik']);


header('Location: index.php');

?>