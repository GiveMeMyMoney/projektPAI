<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2016-01-07
 * Time: 01:23
 */

require_once "../../BazaDanych/DBconnection.php";

$idTowar = $_POST['idTowar'];

debug_to_console($idTowar);

echo "<script type='text/javascript'>alert('$idTowar');</script>";


/**
 * w zawiazku z tym iz nie zawsze dzialalo usuwanie po ID
 * wybieram nazwe i usuwam po nazwie.
 */
$dbconn = getConnection();
//$magNazwa =  mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT mag_nazwa FROM magazyn WHERE mag_id = '$nazwaMagazyn';"));
mysqli_query($dbconn, "DELETE FROM towar WHERE tow_id = '$idTowar';");
if (mysqli_errno($dbconn)){
    debug_to_console("Problem z usunieciem magazynu z BD");
    //$_SESSION['errorDodaniaMagazynuDoBD'] = true;
}

$dbconn->close();