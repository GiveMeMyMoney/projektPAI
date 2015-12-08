<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once "../../BazaDanych/DBconnection.php";
$dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

//usuwamy record z tabeli SESJA gdzie ses_uzk_id == $_COOKIE['id_uzyt']
mysqli_query($dbconn, sprintf("call usun_sesje('%s'); ",
    mysqli_real_escape_string($dbconn, $_COOKIE['id_uzytkownik'])));

//usuwamy COOKIES
setcookie("id_sesja", null, time()-3600, '/');
unset($_COOKIE['id_sesja']);
$_COOKIE['id_sesja'] = null;
setcookie("id_uzytkownik", null, time()-3600, '/');
unset($_COOKIE['id_uzytkownik']);
$_COOKIE['id_uzytkownik'] = null;

debug_to_console($_COOKIE['id_sesja']);
debug_to_console($_COOKIE['id_uzytkownik']);

//wyczyszczenie cache strony.
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

header('Location: index.php');

?>