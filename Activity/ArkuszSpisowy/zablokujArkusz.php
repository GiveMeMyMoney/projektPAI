<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2016-01-02
 * Time: 17:49
 */

require_once "../../BazaDanych/DBconnection.php";

$idArkusz = $_POST['idArkusz'];

debug_to_console($idArkusz);

echo "<script type='text/javascript'>alert('$idArkusz');</script>";

$dbconn = getConnection();
mysqli_query($dbconn, "UPDATE arkusz_spisowy SET ark_czyZablokowany = '1' WHERE ark_id = '$idArkusz';");
if (mysqli_errno($dbconn)){
    debug_to_console("Problem z usunieciem magazynu z BD");
    //$_SESSION['errorDodaniaMagazynuDoBD'] = true;
}

$dbconn->close();

?>