<?php
session_start();

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

/**
 * Sprawdzam czy wybrano magazyn
 */
if(!isset($_COOKIE['id_magazyn']) && $_COOKIE['id_magazyn'] == null){
    header('Location: ../Magazyn/magazyn.php');
}

/**
 * Sprawdzam czy wybrano kategorie
 */
if(!isset($_COOKIE['id_kategoria']) && $_COOKIE['id_kategoria'] == null){
    header('Location: kategoria.php');
}


function displayCommodity($nr, $idTow, $idTowarArkusz, $name, $bareCode, $date, $arkusz, $stan)
{
    echo '<tr>';
        echo '<th bgcolor="silver">' . $nr . '</th>';
        echo '<td>' . $name . '</td>';
        echo '<td>' . $bareCode . '</td>';
        echo '<td>' . $date . '</td>';

        if ($arkusz != null) {
            $dbconn = getConnection();
            $result = mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT ark_numer FROM arkusz_spisowy WHERE ark_id = '$arkusz';"));
            echo '<td>' . $result['ark_numer'] . '</td>';
        } else {
            echo '<td> n/a </td>';
        }

        //stan
        $dbconn = getConnection();
        $result = mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT * FROM stan_rzeczywisty WHERE stan_id = '$stan';"));
        if ($result['stan_pelnowartosciowe'] != null || $result['stan_uszkodzone'] != null || $result['stan_zniszczone'] != null || $result['stan_przeterminowane'] != null) {
            echo '<td>' . $result['stan_ilosc_calosciowy'] . '</td>';
        } else {
            echo '<td> n/a </td>';
        }

        //TODO cos to zle wyswietla...
        echo '<td> <div class="delete" onclick="deleteCommodity(' . $idTow . ');" >' ;
        echo '<a href="javascript: void(0)" class="tilelink">';
        echo '<i class="icon-plus"></i>';
        echo '</a>';
        echo '</div> </td>';



        /*echo '<td> <div onclick="deleteCommodity(' . $idTow . ');" class="delete">' ;
        echo '<a href="javascript: void(0)" class="tilelink">';
        echo '<i class="icon-plus"></i>';
        echo '</a>';
        echo '</div> </td>';*/

        if (isset($_COOKIE['opcja_wyboru_towarow']) && $_COOKIE['opcja_wyboru_towarow'] == true) {
            $idArk =  $_COOKIE['id_arkusza'];
            if ($idTowarArkusz == $idArk) {
                echo '<td>' . '<input type="checkbox" name="wybraneTowary[]" value="' . $idTow . '" checked >' . '</td>';
            } else {
                echo '<td>' . '<input type="checkbox" name="wybraneTowary[]" value="' . $idTow . '">' . '</td>';
            }
        }


    echo '</tr>';
}

function checkWhichCheckBoxesAreSelected()
{
    /*if (isset($_POST['food'])) {
        echo 'lohohohoohoho!';
    }*/

    if(in_array('Orange', 'food[]')){
        echo 'Orange was checked!';
    }
}

?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Strona Główna</title>

    <style>
        table,th,td
        {
            /*border:1px solid black;*/
            border-collapse:collapse;

        }
    </style>



    <script type="text/javascript" src="../../cookieScript/cookies.js"></script>
    <script src="../../zPomocnicze/prototype.js" > </script>
    <script>
        /*function wybieranieTowaru()
        {
            delete_cookie('opcja_wyboru_towarow');
            document.getElementById('button').innerHTML = "asd";
        }*/
        /*function sprawdzMagazyn(idMag) {
            var cookie_name = 'id_magazyn';
            create_cookie(cookie_name, idMag, 30, "/");
        }*/

        function deleteCommodity(idTow) {
            var answer = confirm ("Czy na pewno chcesz usunac ten towar z tego magazynu?");
            if (answer) {
                var data = idTow;
                var myAjax = new Ajax.Request('deleteTowarFromDB.php', {
                    method: 'post',
                    parameters: "idTowar=" + data,
                    onSuccess: function (showResponse) {
                        alert("Usunięto towar o id: " + data);
                        //window.location="http://www.yahoo.com/"
                        window.location.reload();
                    }
                });
            }
        }

    </script>


    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->

    <!--Modal from bootstrap-->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" type="text/css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/bootstrap.js"></script>


    <link rel="stylesheet" href="../../Style/styleStrGlowna.css" type="text/css" >
    <link rel="stylesheet" href="../../Style/styleTowar.css" type="text/css" >

    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->

    <link rel="stylesheet" href="../../Fontello/css/fontello.css" type="text/css" >
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

        <a id="sekcja_gora"></a>

        <div class="towarTile">

            <table width="93%">
                <tr>
                    <th bgcolor="silver">&nbsp;</th>
                    <th bgcolor="silver">Nazwa</th>
                    <th bgcolor="silver">Kod kreskowy</th>
                    <th bgcolor="silver">Data dodania</th>
                    <th bgcolor="silver">Arkusz</th>
                    <th bgcolor="silver">Stan</th>
                    <th bgcolor="silver">Usuń</th>
                    <?php
                    if (isset($_COOKIE['opcja_wyboru_towarow']) && $_COOKIE['opcja_wyboru_towarow'] == true) {
                        echo '<th bgcolor="silver">Wybierz</th>';
                    }
                    ?>
                </tr>

                <?php

                $dbconn = getConnection();
                $idMag = $_COOKIE['id_magazyn'];
                $idKat = $_COOKIE['id_kategoria'];
                $result = mysqli_query($dbconn, "SELECT * FROM view_magazyn_towar WHERE mag_id = '$idMag' AND tow_kat_id = '$idKat';");
                $count = $result->num_rows;

                if ($count>0) {
                    if (isset($_COOKIE['opcja_wyboru_towarow']) && $_COOKIE['opcja_wyboru_towarow'] == true) {
                        echo '<form action="towaryArkusz.php" method="post">';
                    }

                    for ($iter = 0; $wierszTowar = mysqli_fetch_array($result); $iter++) {
                        displayCommodity($iter, $wierszTowar['tow_id'], $wierszTowar['tow_ark_id'], $wierszTowar['tow_nazwa'], $wierszTowar['tow_kod_kreskowy'], $wierszTowar['tow_data_odbioru'],
                            $wierszTowar['tow_ark_id'], $wierszTowar['tow_stan_id']);
                    }

                    if (isset($_COOKIE['opcja_wyboru_towarow']) && $_COOKIE['opcja_wyboru_towarow'] == true) {
                        /*echo '<script type="text/javascript">' . 'delete_cookie(\'opcja_wyboru_towarow\');'
                            . '</script>';*/

                        echo '<input  type="submit" style="margin: 10px; margin-right: 25px; color: #fff; background-color: #31b0d5; border-color: #269abc;" class="btn btn-default" value="Wybieram!"/>';
                    echo '</form>';
                    /*echo '<button style="margin: 15px;" type="button" class="btn btn-info btn-lg">Wybieram!</button>';*/
                }
                } else {
                    echo '<div style="margin: 20px; color: red">';
                    echo '*Brak aktualnych towarów dla tej kategorii';
                    echo '</div>';
                }

                //checkWhichCheckBoxesAreSelected();

                ?>

            </table>

        </div>

        <a style="float: left; margin: 15px;" type="button" class="btn btn-info btn-lg" href="#sekcja_gora">W górę</a>

        <!-- Trigger the modal with a button -->
        <button style="float: right; margin: 15px;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Dodaj towar</button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Nowy Magazyn</h2>
                    </div>
                    <div class="modal-body">
                        <p>Wprowadź dane:</p>
                        <form action="addTowarToDB.php" method="post">
                            Nazwa: <input type="text" maxlength="28" name="nazwa" required  /> <br>
                            Kod kreskowy: <input type="text" name="kodKreskowy" required /> <br>
                            <input style="float: right; margin: 10px;" type="submit" class="btn btn-default" value="Dodaj"/>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <div style="clear: both" ></div>

    <?php
    include('../footer.php');
    ?>

</div>

</body>

</html>

<!--<table width="600">
    <tr>
        <th bgcolor="silver">&nbsp;</th>
        <th bgcolor="silver">Surname</th>
        <th bgcolor="silver">Name</th>
        <th bgcolor="silver">Website</th>
        <th bgcolor="silver">EMail</th>
    </tr>
    <tr>
        <th bgcolor="silver">0</th>
        <td>Bakken</td>
        <td>Stig</td>
        <td>n/a</td>
        <td>stig@example.com</td>
    </tr>
    <tr>
        <th bgcolor="silver">1</th>
        <td bgcolor="red">Merz</td>
        <td bgcolor="red">Alexander</td>
        <td bgcolor="red">alex.example.com</td>
        <td bgcolor="red">alex@example.com</td>
    </tr>
    <tr>
        <th bgcolor="silver">2</th>
        <td>Daniel</td>
        <td>Adam</td>
        <td>n/a</td>
        <td>n/a</td>
        <td>
            <a href="javascript: void(0)" class="tilelink">
                <i class="icon-plus"></i> <br/>
            </a>
        </td>
    </tr>
</table>-->