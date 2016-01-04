<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2015-12-30
 * Time: 00:21
 */

require_once "../../BazaDanych/DBconnection.php";

$numerInwentaryzacja = $_POST['numerInwentaryzacja'];

debug_to_console($numerInwentaryzacja);

echo "<script type='text/javascript'>alert('$numerInwentaryzacja');</script>";


/**
 * w zawiazku z tym iz nie zawsze dzialalo usuwanie po ID
 * wybieram nazwe i usuwam po nazwie.
 */
$dbconn = getConnection();
//$magNazwa =  mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT mag_nazwa FROM magazyn WHERE mag_id = '$nazwaMagazyn';"));
mysqli_query($dbconn, "DELETE FROM inwentaryzacja WHERE inw_numer = '$numerInwentaryzacja';");
if (mysqli_errno($dbconn)){
    debug_to_console("Problem z usunieciem inwentaryzacji z BD");
    //$_SESSION['errorDodaniaMagazynuDoBD'] = true;
}

$dbconn->close();

?>