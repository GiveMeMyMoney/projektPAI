<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2016-01-02
 * Time: 14:19
 */

require_once ('../../BazaDanych/DBconnection.php');
$dbconn = getConnection();

mysqli_autocommit($dbconn, false);

$nazwa = $_POST['nazwa'];   //pobranie danych z HTMLa
$kodKreskowy = $_POST['kodKreskowy'];
$idKat = $_COOKIE['id_kategoria'];
$idMag = $_COOKIE['id_magazyn'];

try
{
    $result1 = mysqli_query($dbconn, "INSERT INTO towar (tow_kat_id, tow_nazwa, tow_kod_kreskowy) VALUES ('$idKat', '$nazwa', '$kodKreskowy');");
    if (!$result1) {
        throw new Exception("Error details: " . mysqli_error($dbconn) . ".");
    } else {
        $result2 = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tow_id FROM towar ORDER BY tow_id DESC LIMIT 1"));
        if (!$result2) {
            throw new Exception("Error details: " . mysqli_error($dbconn) . ".");
        } else {
            $result3 = mysqli_query($dbconn, "INSERT INTO magazyn_towar VALUES (NULL, '$idMag', '$result2[tow_id]');");
            if (!$result3) {
                throw new Exception("Error details: " . mysqli_error($dbconn) . ".");
            }
        }
    }
    $dbconn->commit();
    debug_to_console("transakcja zakonczona powodzeniem");
}
catch (Exception $e)
{
    $dbconn->rollback();
    debug_to_console("transakcja zakonczona NIE-powodzeniem");
}

$dbconn->close();

header('Location: towaryMagazyn.php');

?>