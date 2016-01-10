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

if(isset($_SESSION['errorDodaniaMagazynuDoBD']) && $_SESSION['errorDodaniaMagazynuDoBD'] != null){
    echo '<span style="color:red"> Blad zwiazany z insertem do BD </span>';
    unset($_SESSION['errorDodaniaMagazynuDoBD']);
    $_SESSION['errorDodaniaMagazynuDoBD'] = null;
}

function displayWarehouse($idMag, $name, $shortName, $phone, $resort, $street, $nr)
{
    echo '<a href="../Inwentaryzacja/inwentaryzacja.php" onclick="sprawdzMagazyn(' . $idMag . ');" class="tilelink">';
        echo '<div class="magazynTile" >' ;

            echo '<div style="float: left; width: 35%; text-align: center;">';
                echo '<i class="icon-home"></i> <br/>';
                echo $name . "<br/>";
            echo '</div>';

            echo '<div style="float: right; width: 65%; font-size: 90%; position: relative;">';
                echo 'Nazwa: ' . $name . "<br/>";
                echo 'Skrót: ' . $shortName . "<br/>";
                echo 'Telefon: ' . $phone . "<br/>";
                echo 'Miejscowosc: ' . $resort . "<br/>";
                echo 'Ulica: ' . $street . " " . $nr . "<br/>";


                echo '<div onclick="deleteWarehouse(\''.$name.'\');" class="delete">' ;
                    echo '<a href="javascript: void(0)" class="tilelink">';
                    echo '<i style="font-size: 50px;" class="icon-trash-empty"></i> <br/>';
                    echo '</a>';
                echo '</div>';

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
        function sprawdzMagazyn(idMag) {
            try {
                if (idMag < 0) {
                    throw("cos nie tak z BD!");
                }
                var cookie_name = 'id_magazyn';
                create_cookie(cookie_name, idMag, 30, "/");
            } catch (e) {
                alert("Error: " + e);
            }
        }

        function deleteWarehouse(name) {
            var answer = confirm ("Czy na pewno chcesz usunac ten magazyn?");
            if (answer) {
                var data = name;
                var myAjax = new Ajax.Request('deleteMagazynFromDB.php', {
                    method: 'post',
                    parameters: "nazwaMagazyn=" + data,
                    onSuccess: function (showResponse) {
                        alert("Usunięto magazyn o id: " + data);
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
    <link rel="stylesheet" href="../../Style/styleMagazyn.css" type="text/css" >

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

    <div style="float:right; width: 70%;" >
            <?php
                $dbconn = getConnection();
                $result = mysqli_query($dbconn, "SELECT * FROM magazyn;");

            $count = $result->num_rows;

            if ($count>0) {
                while ($wierszMagazyn = mysqli_fetch_array($result)) {
                    displayWarehouse($wierszMagazyn['mag_id'], $wierszMagazyn['mag_nazwa'], $wierszMagazyn['mag_skrot'], $wierszMagazyn['mag_telefon'],
                        $wierszMagazyn['mag_miejscowosc'], $wierszMagazyn['mag_ulica'], $wierszMagazyn['mag_nr']);
                }
            } else {
                echo '<div style="margin: 20px; color: red">';
                echo '*Brak aktualnych magazynów';
                echo '</div>';
            }



            ?>

        <!-- Trigger the modal with a button -->
        <button style="float: right; margin: 15px;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Dodaj magazyn</button>

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
                        <form action="addMagazynToDB.php" method="post">
                            Nazwa: <input type="text" maxlength="28" name="nazwa" required  /> <br>
                            Skrót: <input type="text" name="skrot" required /> <br>
                            Telefon: <input type="number"  name="telefon"  required /> <br>
                            Miejscowosc: <input type="text" name="miejscowosc"  required /> <br>
                            Ulica: <input type="text" name="ulica"  required /> <br>
                            Numer Budynku: <input type="number" name="numer"  required />
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
