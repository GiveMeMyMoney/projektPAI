<?php

session_start();

include("../../BazaDanych/DBconnection.php");

if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==true) {
    header('Location: ../StrGlowna/strGlowna.php');
    exit();
}

if (isset($_SESSION['bladHasla']) &&  $_SESSION['bladHasla']==true) {
    echo '<span style="color:red"> Nieprawidlowe haslo!</span>';
    unset($_SESSION['bladHasla']); $_SESSION['bladHasla'] = false;
}

if (isset($_SESSION['bladLoginu']) &&  $_SESSION['bladLoginu']==true) {
    echo '<span style="color:red"> Nieprawidlowy login!</span>';
    unset($_SESSION['bladLoginu']); $_SESSION['bladLoginu'] = false;
}

?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Moja strona WWW</title>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

    <link rel="stylesheet" href="../../Style/styleStrLogowanie.css" type="text/css" >
    <link rel="stylesheet" href="../Fontello/css/fontello.css" type="text/css" >
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
                <i class="icon-user-1"></i> <br/>Dodaj użytkownika
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

