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
 * Sprawdzam czy wybrano inwentaryzacje
 */
if(!isset($_COOKIE['id_inwentaryzacji']) && $_COOKIE['id_inwentaryzacji'] == null){
    header('Location: ../Inwentaryzacja/inwentaryzacja.php');
}


function displayArkuszSpisowy($idArk, $numer, $czyZablokowany, $arkDataRozpoczęcia, $arkDataZakonczenia, $arkOpis)
{
    if ($czyZablokowany) {
        echo '<div class="arkuszSpisowyTile" >';
    } else {
        echo '<a href="../Towary/towaryArkusz.php" onclick="sprawdzArkusz(' . $idArk . ');" class="tilelink">';
        echo '<div class="arkuszSpisowyTileWithHover" >';
    }
            echo '<div style="float: left; width: 40%">';
                echo 'ZDJECIE: ' . $numer . "<br/>";
            echo '</div>';

            echo '<div style="float: right; width: 60%; position: relative">';
                echo 'Arkusz: ' . $numer . "<br/>";
                if ($czyZablokowany) {
                    echo 'Stan: <span style="color:red">zakończony</span>' . "<br/>";
                } else {
                    echo 'Stan: rozpoczęty' . "<br/>";
                }
                echo 'Data rozpoczęcia: ' . $arkDataRozpoczęcia . "<br/>";
                if ($arkDataZakonczenia != null) {
                    echo 'Data zakończenia: ' . $arkDataZakonczenia . "<br/>";
                }
                echo 'Opis: ' . $arkOpis . "<br/>";

                echo '<div onclick="deleteArkuszSpisowy(\''.$numer.'\');" class="delete">' ;
                    echo '<a href="javascript: void(0)" class="tilelink">';
                    echo '<i class="icon-plus"></i> <br/>';
                    echo '</a>';
                echo '</div>';

            echo '</div>';

        echo '</div>';

    if (!$czyZablokowany) {
        echo '</a>';
    }

}

?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Strona Główna</title>

    <script type="text/javascript" src="../../cookieScript/cookies.js"></script>
    <script src="../../zPomocnicze/prototype.js" > </script>
    <script>
        function sprawdzArkusz(idArk) {
            var cookie_name = 'id_arkusza';
            create_cookie(cookie_name, idArk, 30, "/");
        }

        function deleteArkuszSpisowy(numer) {
            var answer = confirm ("Czy na pewno chcesz usunac ten arkusz?");
            if (answer) {
                var data = numer;
                var myAjax = new Ajax.Request('deleteArkuszSpisowyFromDB.php', {
                    method: 'post',
                    parameters: "numerArkusz=" + data,
                    onSuccess: function (showResponse) {
                        alert("Usunięto arkusz o numerze: " + data);
                        //window.location="http://www.yahoo.com/"
                        window.location.reload();
                    }
                });
            }
            <?php
              /* if(isset($_COOKIE['id_magazyn']) && $_COOKIE['id_magazyn'] != null){
                   $dbconn = getConnection();
                   $wierszMagazyn = mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT mag_nazwa FROM magazyn WHERE mag_id = '$_COOKIE[id_magazyn]';"));
                   echo 'Magazyn: ' . $wierszMagazyn['mag_nazwa'];
                   $dbconn->close();
               } else {
                   echo '<a href="../Magazyn/magazyn.php" class="tilelink">Wybierz magazyn</a>';
               }
           */?>
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
    <link rel="stylesheet" href="../../Style/styleArkuszSpisowy.css" type="text/css" >

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

        <?php
        $dbconn = getConnection();
        $idInwentaryzacji =  $_COOKIE['id_inwentaryzacji'];
        $result = mysqli_query($dbconn, "SELECT * FROM arkusz_spisowy WHERE ark_inw_id = '$idInwentaryzacji';");
        $count = $result->num_rows;

        if ($count>0) {
            while ($wierszArkuszSpisowy = mysqli_fetch_array($result)) {
                displayArkuszSpisowy($wierszArkuszSpisowy['ark_id'], $wierszArkuszSpisowy['ark_numer'], $wierszArkuszSpisowy['ark_czyZablokowany'],
                    $wierszArkuszSpisowy['ark_data_rozp'], $wierszArkuszSpisowy['ark_data_zakon'], $wierszArkuszSpisowy['ark_opis']);
            }
        } else {
            echo '<div style="margin: 20px; color: red">';
            echo '*Brak aktualnych arkuszy spisowych dla tej inwentaryzacji';
            echo '</div>';
        }


        ?>

        <!-- Trigger the modal with a button -->
        <button style="float: right; margin: 15px;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Nowy</button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Nowy arkusz spisowy</h2>
                    </div>
                    <div class="modal-body">
                        <p>Wprowadź dane:</p>
                        <form action="addArkuszSpisowyToDB.php" method="post">
                            Numer: <input type="text" maxlength="28" name="numer" required  /> <br>
                            Opis: <input type="text" name="opis" /> <br>
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