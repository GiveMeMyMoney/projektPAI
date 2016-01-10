<?php

require_once ('../../BazaDanych/DBconnection.php');
$numer = $_POST['numer'];   //pobranie danych z HTMLa
$opis = $_POST['opis'];
$idMagazyn = $_COOKIE['id_magazyn'];

var_dump($numer . "i: " . $opis . "i: " . $idMagazyn);

debug_to_console("Jestem w insert");
$dbconn = getConnection();
mysqli_query($dbconn, "INSERT INTO inwentaryzacja (inw_mag_id, inw_numer, inw_opis) VALUES ('$idMagazyn', '$numer', '$opis');");
if (mysqli_errno($dbconn)){
    debug_to_console("Problem z dodaniem inwentaryzacji do BD");
    //$_SESSION['errorDodaniaMagazynuDoBD'] = true;
}

$dbconn->close();

header('Location: inwentaryzacja.php');

?>