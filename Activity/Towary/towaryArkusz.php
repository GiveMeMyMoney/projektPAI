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
 * Sprawdzam czy czasem arkusz nie jest zablokowany
 */
if(isset($_COOKIE['id_arkusza']) && $_COOKIE['id_arkusza'] != null){
    $dbconn = getConnection();
    $idInwentaryzacji =  $_COOKIE['id_inwentaryzacji'];
    $result = mysqli_fetch_array(mysqli_query($dbconn, "SELECT ark_czyZablokowany FROM arkusz_spisowy WHERE ark_inw_id = '$idInwentaryzacji';"));

    //cos nie dziala ten alert
    if ($result['ark_czyZablokowany']) {
        echo "<script type=\"text/javascript\">
            alert(\"Ten arkusz jest ZABLOKOWANY!\");
          </script>";
        header('Location: ../ArkuszSpisowy/arkusz.php');
    }
} else {
    //cos nie dziala ten alert
    echo "<script type=\"text/javascript\">
            alert(\"Nie wybrano inwentaryzacji!\");
          </script>";
    header('Location: ../ArkuszSpisowy/arkusz.php');
}

//TODO gdy zaden CB nie ustawiony nie ma POST - trzeba jakos automatycznie wymusic...
//TODO nie pozwalac juz zalaczonym towarom na bycie dolaczonym do innego arkusza?  TAK czy NIE?
///ta czesc kodu psuje polskie znaki WHY?!?

function sprawdzTowary()
{
    $ilosc = 0;
    if (isset($_POST['wybraneTowary'])) {
        $dbconn = getConnection();
        mysqli_autocommit($dbconn, false);

        $arrWybraneTowary = $_POST['wybraneTowary'];
        $ilosc = count($arrWybraneTowary);
        $idArk =  $_COOKIE['id_arkusza'];
        var_dump($idArk);
        try
        {
            /**
             * zle zrobiona transakcja do poprawy!
             */
            $resultStare = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tow_id FROM towar WHERE tow_ark_id = '$idArk';"));
            /*while ($resultStare) {
                var_dump($resultStare['tow_id']);
            }*/
            var_dump($resultStare);
            if (false) {
                throw new Exception("Error details: " . mysqli_error($dbconn) . ".");
            } else {
                $resultMaxID = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tow_id FROM towar ORDER BY tow_id DESC LIMIT 1"));
                if (false) {
                    throw new Exception("Error details: " . mysqli_error($dbconn) . ".");
                } else {
                    $maxTowID = $resultMaxID['tow_id'];
                    var_dump($maxTowID);
                    /**
                     * jesli zadne towary NIE byly przypisane do arkusza
                     */
                    if ($resultStare == null) {
                        var_dump("1 opcja");
                        for ($idTow = 1; $idTow <= $maxTowID; $idTow++) {
                            if (in_array($idTow, $arrWybraneTowary)) {
                                var_dump($idTow . ' w 1 opcji zaznaczony');
                                debug_to_console($idTow . ' w 1 opcji zaznaczony');

                                $resultUpdate = mysqli_query($dbconn, "UPDATE towar SET tow_ark_id = '$idArk' WHERE tow_id = '$idTow';");
                                if (!$resultUpdate) {
                                    throw new Exception("Error details: " . mysqli_error($dbconn) . ".");
                                }
                            }
                        }

                    }
                    /**
                     * jesli jakies towary byly przypisane do arkusza
                     */
                    else {
                        var_dump("2 opcja");
                        for ($idTow = 1; $idTow <= $maxTowID; $idTow++) {
                            //te ktore byly zaznaczone
                            if (in_array($idTow, $resultStare)) {
                                //jesli teraz nie sa = UPDATE
                                if (!in_array($idTow, $arrWybraneTowary)) {
                                    var_dump($idTow . ' w 2 opcji odznaczony');
                                    $resultUpdate = mysqli_query($dbconn, "UPDATE towar SET tow_ark_id = NULL WHERE tow_id = '$idTow';");
                                    if (!$resultUpdate) {
                                        throw new Exception("Error details: " . mysqli_error($dbconn) . ".");
                                    }
                                }
                            } else if (in_array($idTow, $arrWybraneTowary)) {
                                var_dump($idTow . ' w 2 zaznaczony!');
                                debug_to_console($idTow . ' was checked!');

                                $resultUpdate = mysqli_query($dbconn, "UPDATE towar SET tow_ark_id = '$idArk' WHERE tow_id = '$idTow';");
                                if (!$resultUpdate) {
                                    throw new Exception("Error details: " . mysqli_error($dbconn) . ".");
                                }
                            }
                        }

                    }


                    /*$result3 = mysqli_query($dbconn, "INSERT INTO magazyn_towar VALUES (NULL, '$idMag', '$result2[tow_id]');");
                    if (!$result3) {
                        throw new Exception("Error details: " . mysqli_error($dbconn) . ".");
                    }*/
                }
            }
            $dbconn->commit();
            debug_to_console("transakcja zakonczona powodzeniem");
        }
        catch (Exception $e)
        {
            $dbconn->rollback();
            debug_to_console("transakcja zakonczona NIE-powodzeniem: " . $e->getMessage());
        }

        //$dbconn->close();
        /*if (in_array('5', $arrWybraneTowary)) {
            echo 5 . ' was checked!';
        }*/

    }
    return $ilosc;
}

//if(isset($_POST['food']) && in_array(...



function displayTowar($nr, $idTow, $idStan, $name, $bareCode, $date)
{
    echo '<tr>';
        echo '<th bgcolor="silver">' . $nr . '</th>';
        echo '<td>' . $name . '</td>';
        echo '<td>' . $bareCode . '</td>';
        echo '<td>' . $date . '</td>';

        $dbconn = getConnection();
        $result = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM stan_rzeczywisty WHERE stan_id = '$idStan';"));


        echo '<td>' . '<input type="number" name="nrPelnowartosciowe[]" value="' . $result['stan_pelnowartosciowe'] . '" step="0.01" min="0" style="width: 60px;"/>' . '</td>';
        echo '<td>' . '<input type="number" name="nrUszkodzone[]" value="' . $result['stan_uszkodzone'] . '" step="0.01" min="0" style="width: 60px;"/>' . '</td>';
        echo '<td>' . '<input type="number" name="nrZniszczone[]" value="' . $result['stan_zniszczone'] . '" step="0.01" min="0" style="width: 60px;"/>' . '</td>';
        echo '<td>' . '<input type="number" name="nrPrzeterminowane[]" value="' . $result['stan_przeterminowane'] . '" step="0.01" min="0" style="width: 60px;"/>' . '</td>';
        echo '<td>' . '<input type="hidden" name="inwentStan[]" value="' . $idStan . '" />' . '</td>';

    echo '</tr>';

}

function displayKategoria($idKat, $nazwa, $opis)
{
    echo '<a href="towaryMagazyn.php" onclick="sprawdzKategoria(' . $idKat . ');" class="tilelink">';
    echo '<div class="kategoriaTile" >';

    echo '<div style="float: left; width: 35%; text-align: center;">';
    echo '<i class="icon-home"></i> <br/>';
    echo $nazwa . "<br/>";
    echo '</div>';

    echo '</div>';
    echo '</a>';
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
        function isDecimalKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function sprawdzKategoria(idKat) {
            var cookie_name = 'id_kategoria';
            create_cookie(cookie_name, idKat, 30, "/");

            cookie_name = 'opcja_wyboru_towarow';
            create_cookie(cookie_name, true, 30, "/");
        }

        function zablokujArkusz()
        {
            var answer = confirm ("Czy na pewno chcesz zablokować ten arkusz? (nie będzie możliwe cofnięcie operacji)");
            if (answer) {
                var data = retrieve_cookie('id_arkusza');
                var myAjax = new Ajax.Request('../ArkuszSpisowy/zablokujArkusz.php', {
                    method: 'post',
                    parameters: "idArkusz=" + data,
                    onSuccess: function (showResponse) {
                        //window.location="http://www.yahoo.com/"
                        window.location="../ArkuszSpisowy/arkusz.php";
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
    <link rel="stylesheet" href="../../Style/styleKategoria.css" type="text/css" >

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

        <button onclick="zablokujArkusz()" style="margin: 15px;" type="button" class="btn btn-info btn-lg">Zablokuj</button>

        <div class="towarTile">
            <table width="93%">
                <tr>
                    <th bgcolor="silver">&nbsp;</th>
                    <th bgcolor="silver">Nazwa</th>
                    <th bgcolor="silver">Kod kreskowy</th>
                    <th bgcolor="silver">Data dodania</th>
                    <th bgcolor="silver">Pełno<br>wartościowe</th>
                    <th bgcolor="silver">Uszko<br>dzone</th>
                    <th bgcolor="silver">Znisz<br>czone</th>
                    <th bgcolor="silver">Przeter<br>minowane</th>
                </tr>

                <?php

                $ilosc = sprawdzTowary();

                $dbconn = getConnection();
                $idArk =  $_COOKIE['id_arkusza'];
                $result = mysqli_query($dbconn, "SELECT * FROM towar WHERE tow_ark_id = '$idArk';");
                $count = $result->num_rows;

                if ($count>0) {
                    echo '<form action="updateStanTowarow.php" method="post">';
                    for ($iter=0; $wierszTowar = mysqli_fetch_array($result); $iter++) {
                        displayTowar($iter, $wierszTowar['tow_id'], $wierszTowar['tow_stan_id'], $wierszTowar['tow_nazwa'], $wierszTowar['tow_kod_kreskowy'], $wierszTowar['tow_data_odbioru']);
                    }
                    echo '<input type="submit" style="margin: 10px; margin-right: 25px; color: #fff; background-color: #31b0d5; border-color: #269abc;" class="btn btn-default" value="Wprowadź zmiany"/>';
                } else {
                    echo '<div style="margin: 20px; color: red">';
                    echo '*Brak aktualnych towarów dla tego arkusza spisowego';
                    echo '</div>';
                }


                ?>

            </table>
        </div>

        <!-- Trigger the modal with a button -->
        <button style="float: right; margin: 15px;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Dodaj towary</button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Dodaj towar do arkusza</h2>
                    </div>
                    <div class="modal-body">
                        <p>Wybierz kategorie:</p>
                        <?php
                        $dbconn = getConnection();
                        $result = mysqli_query($dbconn, "SELECT * FROM kategoria_towaru;");
                        $count = $result->num_rows;

                        if ($count>0) {
                            while ($wierszKategoria = mysqli_fetch_array($result)) {
                                displayKategoria($wierszKategoria['kt_id'], $wierszKategoria['kt_nazwa'], $wierszKategoria['kt_opis']);
                            }
                        } else {
                            echo '<div style="margin: 20px; color: red">';
                            echo '*Brak aktualnych kategorii';
                            echo '</div>';
                        }
                        ?>
                        <!--<form action="addInwentaryzacjaToDB.php" method="post">
                            Numer: <input type="text" maxlength="28" name="numer" required  /> <br>
                            Opis: <input type="text" name="opis" /> <br>
                            <input style="float: right; margin: 10px;" type="submit" class="btn btn-default" value="Dodaj"/>
                        </form>-->
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