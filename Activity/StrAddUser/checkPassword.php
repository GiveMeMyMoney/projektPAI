<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2015-12-16
 * Time: 14:54
 */

require_once "../../BazaDanych/DBconnection.php";

$haslo = $_POST['haslo2'];
$hasloCheck = $_POST['haslo2Check'];

debug_to_console($haslo);
debug_to_console($hasloCheck);

if ($haslo != $hasloCheck) {
    echo "*Hasła nie zgadzają się!";
} else {
    debug_to_console("Hasla takie same");
}


?>