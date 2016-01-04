<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once "../../BazaDanych/DBconnection.php";
/**
 * sprawdzam czy ustawione zmienne $_COOKIE['id_uzytkownik']
 */
debug_to_console($_COOKIE['id_sesja']);
debug_to_console($_COOKIE['id_uzytkownik']);

if(!isset($_COOKIE['id_uzytkownik']) || $_COOKIE['id_uzytkownik'] == null){
    debug_to_console('jestem w');
    header('location: ../StrLogowanie/index.php');
    exit();
}

debug_to_console($_COOKIE['id_sesja'] . "po");
debug_to_console($_COOKIE['id_uzytkownik'] . "po");

/**
 * Sprawdzam czy istnieje record w tabeli SESJA o podanych cookisach.
 */
$dbconn = getConnection();
$wierszSesja = mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT ses_uzk_id FROM sesja WHERE
      ses_id = '$_COOKIE[id_sesja]';"));

debug_to_console("Taki uzk: " . $wierszSesja['ses_uzk_id']);
if (empty($wierszSesja['ses_uzk_id'])){
    header('location: ../StrLogowanie/index.php');exit;
}

?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Strona Glowna</title>

    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" type="text/css" >

    <link rel="stylesheet" href="../../Style/styleStrGlowna.css" type="text/css" >
    <link rel="stylesheet" href="../../Fontello/css/fontello.css" type="text/css" >
    <link rel="stylesheet" href="../../Fontello2/css/fontello.css" type="text/css" >
    <link href='https://fonts.googleapis.com/css?family=Lato|Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body>
    <div id="container">
        <?php
            include('../header.php');
        ?>

        <?php
        include('../leftPanel.php');
        ?>


        <div style="float:right; width: 70%; background-color: #fffc26;" >
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in</p>
            <p>voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

        </div>
        <div style="clear: both" ></div>


        <?php
            include('../footer.php');
        ?>

    </div>

</body>

</html>
