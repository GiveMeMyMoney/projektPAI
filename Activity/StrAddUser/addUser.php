<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2015-10-13
 * Time: 22:13
 */

if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==true) {
    header('Location: ../StrGlowna/strGlowna.php');
    exit();
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Dodaj Użytkownika</title>
    <link rel="stylesheet" href="../../Style/styleAddUser.css" type="text/css" >
    <link rel="stylesheet" href="../Fontello/css/fontello.css" type="text/css" >
    <script src="../../zPomocnicze/prototype.js" > </script>
    <link href='https://fonts.googleapis.com/css?family=Lato|Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

    <script>
        function checkUser(){
            var login = document.getElementById("login2").value;
            var errorResult = document.getElementById("loginCheck");
            if(login=='')
                errorResult.innerHTML = 'Błąd: Nie podano <b>Loginu</b>';
            errorResult.innerHTML = '';
            var myAjax = new Ajax.Request('checkLogin.php', {
                method: 'post',
                parameters: "login2=" + login,
                onSuccess: function(showResponse){
                    errorResult.innerHTML  = showResponse.responseText;
                }
            });
        }
    </script>

</head>

<body>

<div id="container">
    <div class="rectangle">
        <div id="tytul">Dodaj Użytkownika
            <!--ew. drugi-->
        </div>
        <div style="clear: both" > </div>
    </div>

    <div class="square">
        <a href="../StrAddUser/addUser.php" class="tilelink"> <div class="tile1">
                <i class="icon-user-1"></i> <br/>O mnie
            </div> </a>
        <a href="../StrAddUser/addUser.php" class="tilelink"> <div class="tile2">
                <i class="icon-info-circled"></i> <br/>O programie
            </div> </a>
        <div style="clear: both" > </div>
    </div>
    <div class="square">
        <div class="tile3" >
            <form action="addUserToDB.php" method="post">
                    <div id="login">    <!--niech na razie bedzie to ID-->
                        Login: <input type="text" maxlength="28" name="login2" id="login2" placeholder="Mój login" onblur="checkUser()" required  style="margin-left: 64px"/>
                    </div>
                    <div id="loginCheck"></div>
                    <div id="haslo" >
                        Hasło: <input type="password" name="haslo2" placeholder="Moje haslo" required style="margin-left: 62px"/>
                    </div>
                    <div id="imie">    <!--niech na razie bedzie to ID-->
                        Imie: <input type="text"  name="imie" placeholder="Jan" required style="margin-left: 74px"/>
                    </div>
                    <div id="nazwisko" >
                        Nazwisko: <input type="text" name="nazwisko" placeholder="Kowalski" required style="margin-left: 28px"/>
                    </div>
                    <div id="telefon">    <!--niech na razie bedzie to ID-->
                        Telefon: <input type="number"  name="telefon" placeholder="656898767" required style="margin-left: 45px"/>
                    </div>
                    <div id="email" >
                        E-mail: <input type="email" name="email" placeholder="jan.kowalski@address.com" required style="margin-left: 58px"/>
                    </div>
                    <div id="dataZatrudnienia" >
                        Data zatrudnienia: <input type="date" name="dataZatrudnienia" required />
                    </div>
                <input type="submit" id="submitBtn" value="Założ konto!"/>
            </form>
        </div>
    </div>
    <div style="clear: both" ></div>

    <div class="rectangleBottom" >
        2015 &copy; Inwentaryzacja towarów na Magazynie - zapraszam! <i class="icon-mail-alt"></i> marcin.styczen1@gmail.com
    </div>
</div>

</body>

</html>
