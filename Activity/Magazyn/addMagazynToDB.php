<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2015-12-28
 * Time: 16:35
 */

require_once ('../../BazaDanych/DBconnection.php');
$dbconn = getConnection();

$nazwa = $_POST['nazwa'];   //pobranie danych z HTMLa
$skrot = $_POST['skrot'];
$telefon = $_POST['telefon'];
$miejscowosc = $_POST['miejscowosc'];
$ulica = $_POST['ulica'];
$numer = $_POST['numer'];

debug_to_console("Jestem w insert");
$dbconn = getConnection();
mysqli_query($dbconn, "INSERT INTO magazyn VALUES (NULL, '$nazwa', '$skrot', '$telefon', '$miejscowosc', '$ulica', '$numer');");
if (mysqli_errno($dbconn)){
    debug_to_console("Problem z dodaniem magazynu do BD");
    $_SESSION['errorDodaniaMagazynuDoBD'] = true;
}

$dbconn->close();

header('Location: magazyn.php');

?>