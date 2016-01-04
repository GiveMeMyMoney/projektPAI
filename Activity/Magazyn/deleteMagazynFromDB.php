<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2015-12-29
 * Time: 22:25
 */

require_once "../../BazaDanych/DBconnection.php";

$nazwaMagazyn = $_POST['nazwaMagazyn'];

debug_to_console($nazwaMagazyn);

echo "<script type='text/javascript'>alert('$nazwaMagazyn');</script>";


/**
 * w zawiazku z tym iz nie zawsze dzialalo usuwanie po ID
 * wybieram nazwe i usuwam po nazwie.
 */
$dbconn = getConnection();
//$magNazwa =  mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT mag_nazwa FROM magazyn WHERE mag_id = '$nazwaMagazyn';"));
mysqli_query($dbconn, "DELETE FROM magazyn WHERE mag_nazwa = '$nazwaMagazyn';");
if (mysqli_errno($dbconn)){
    debug_to_console("Problem z usunieciem magazynu z BD");
    //$_SESSION['errorDodaniaMagazynuDoBD'] = true;
}

$dbconn->close();

?>