<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2016-01-10
 * Time: 02:19
 */

require_once ('../../BazaDanych/DBconnection.php');

$nazwa = $_POST['nazwa'];   //pobranie danych z HTMLa

debug_to_console("Jestem w insert");
$dbconn = getConnection();
mysqli_query($dbconn, "INSERT INTO kategoria_towaru VALUES (NULL, '$nazwa');");
if (mysqli_errno($dbconn)){
    debug_to_console("Problem z dodaniem magazynu do BD");
    //$_SESSION['errorDodaniaMagazynuDoBD'] = true;
}

$dbconn->close();

header('Location: kategoria.php');

?>