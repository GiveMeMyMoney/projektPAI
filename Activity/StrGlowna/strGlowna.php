<?php

session_start();

if(!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany']==false) {
    header('Location: ../StrLogowanie/index.php');
    exit();
}

?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Strona Glowna</title>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

    <link rel="stylesheet" href="../../Style/styleStrGlowna.css" type="text/css" >
    <link rel="stylesheet" href="../Fontello/css/fontello.css" type="text/css" >
    <link href='https://fonts.googleapis.com/css?family=Lato|Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body>
    <div id="container">
        <div id="header">
            <div class="tytul"><?php
                    echo "Witaj ".$_SESSION['uzytkownik']."!";
                ?>
            </div>
            <div class="dane">
                Dane
            </div>
            <div class="wyloguj">
                <a href = "../StrLogowanie/logOut.php"> Wyloguj! </a>
            </div>
            <div style="clear: both" > </div>
        </div>


        <div style="float:left; width: 30%; background-color: #98951f;" >
            <a href="../StrAddUser/addUser.php" class="tilelink"> <div class="tile" >
                    <i class="icon-user-1"></i> <br/>Magazyny
                </div> </a>
            <a href="../StrAddUser/addUser.php" class="tilelink"> <div class="tile" >
                    <i class="icon-user-1"></i> <br/>Dodaj użytkownika
                </div> </a>
            <div style="clear: both" ></div>
            <a href="../StrAddUser/addUser.php" class="tilelink"> <div class="tile" >
                    <i class="icon-user-1"></i> <br/>Dodaj użytkownika
                </div> </a>
            <a href="../StrAddUser/addUser.php" class="tilelink"> <div class="tile" >
                    <i class="icon-user-1"></i> <br/>Dodaj użytkownika
                </div> </a>
            <div style="clear: both" ></div>


        </div>

        <div style="float:right; width: 70%; background-color: #fffc26;" >
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in</p>
            <p>voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

        </div>
        <div style="clear: both" ></div>



        <div id="footer" >
            2015 &copy; Inwentaryzacja towarów na Magazynie - zapraszam! <i class="icon-mail-alt"></i> marcin.styczen1@gmail.com
        </div>

    </div>

</body>

</html>
