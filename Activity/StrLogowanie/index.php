<?php

session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once("../../BazaDanych/DBconnection.php");
include("usunCookies.php");

usunCookies();

if (isset($_COOKIE['bladSQL']) &&  $_COOKIE['bladSQL']==true) {
    echo '<span style="color:red"> Blad zwiazany z zapytaniem do BD </span>';
    setcookie("bladSQL", null, time()-3600, '/');
}

if (isset($_COOKIE['bladHasla']) &&  $_COOKIE['bladHasla']==true) {
    echo '<span style="color:red"> Nieprawidłowe haslo!</span>';
    setcookie("bladHasla", null, time()-3600, '/');
}

if (isset($_COOKIE['bladLoginu']) &&  $_COOKIE['bladLoginu']==true) {
    echo '<span style="color:red"> Nieprawidłowy login!</span>';
    setcookie("bladLoginu", null, time()-3600, '/');
}

/**
 * Sprawdzanie czy przypadkiem(np jesli ktos zalogowany cofnie strone) ktos nie jest zalogowany,
 * wtedy przekierowuje.
 */
if(isset($_COOKIE['id_uzytkownik']) && $_COOKIE['id_uzytkownik'] != null) {
    $dbconn = getConnection();
    if($result = $dbconn->query(sprintf("SELECT * FROM sesja WHERE ses_id = '%s'; ", mysqli_real_escape_string($dbconn, $_COOKIE['id_sesja'])))) {
        $row = $result->num_rows;
        if ($row > 0) {
            header('location: ../StrGlowna/strGlowna.php');
            exit();
        }
    }
    $dbconn->close();
}

?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Moja strona WWW</title>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

    <noscript>
        Brak włączonej obsługi JavaScript. By nasz serwis działał prawidłowo musisz włączyć obsługe JavaScript!
    </noscript>
    <script type="text/javascript" src="../../cookieScript/cookies.js"></script>
    <script>
        checkCookie();
    </script>

    <link rel="stylesheet" href="../../Style/styleStrLogowanie.css" type="text/css" >
    <link rel="stylesheet" href="../../Fontello/css/fontello.css" type="text/css" >
    <link href='https://fonts.googleapis.com/css?family=Lato|Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body>

    <div id="container">
        <div class="rectangle">
            <div id="tytul">Inwentaryzacja Magazynowa
            <!--ew. drugi-->
            </div>
            <div style="clear: both" > </div>
        </div>

        <div class="square">
            <a href="../StrAddUser/addUser.php" class="tilelink">
                <div class="tile1">
                    <i class="icon-user-1"></i> <br/>O mnie
                </div>
            </a>
            <a href="../StrAddUser/addUser.php" class="tilelink">
                <div class="tile2">
                    <i class="icon-info-circled"></i> <br/>O programie
                </div>
            </a>
            <div style="clear: both" > </div>
        </div>
        <div class="square">
            <div class="tile3" >
                <form action="logIn.php" method="post">
                    <div id="login">    <!--niech na razie bedzie to ID-->
                        Login: <input type="text"  name="login" style="margin-left: 3px"/>
                    </div>
                    <div id="haslo" >
                        Hasło: <input type="password" name="haslo"/>
                    </div>
                    <input type="submit" id="submitBtn" value="LOG IN"/>
                </form>
            </div>
            <a href="../StrAddUser/addUser.php" class="tilelink"> <div class="tile4" >
                <i class="icon-user-plus"></i> <br/>Dodaj użytkownika
            </div> </a>
            <div style="clear: both" ></div>

        </div>
        <div style="clear: both" ></div>

        <div class="rectangleBottom" >
            2015 &copy; Inwentaryzacja towarów na Magazynie - zapraszam! <i class="icon-mail-alt"></i> marcin.styczen1@gmail.com
        </div>
    </div>
</body>

</html>

