<?php

require_once ('../../BazaDanych/DBconnection.php');
$dbconn = getConnection();
//w oparciu o cookies

$numer = $_POST['numer'];   //pobranie danych z HTMLa
$opis = $_POST['opis'];
$idInw = $_COOKIE['id_inwentaryzacji'];
$dataRozpoczecia = date('Y-m-d H:i:s');

debug_to_console("Jestem w insert");
$dbconn = getConnection();
mysqli_query($dbconn, "INSERT INTO arkusz_spisowy (ark_inw_id, ark_numer, ark_data_rozp, ark_opis) VALUES ('$idInw', '$numer', '$dataRozpoczecia', '$opis');");
if (mysqli_errno($dbconn)) {
    debug_to_console("Problem z dodaniem arkusza_spisowego do BD");
    //$_SESSION['errorDodaniaMagazynuDoBD'] = true;
}

$dbconn->close();

header('Location: arkusz.php');

?>