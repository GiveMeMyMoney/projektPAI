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
    <html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
          xmlns:text-align="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Strona Główna</title>

    <script type="text/javascript" src="../../cookieScript/cookies.js"></script>
    <script>
        function sprawdzKategoria(idKat) {
            var cookie_name = 'id_kategoria';
            create_cookie(cookie_name, idKat, 30, "/");
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

    <div style="float:right; width: 70%; background-color: #fffc26;">

        <p style="text-align: center; font-size: 180%; padding-top: 10px; color: #0f0f0f">Kategoria</p>

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


    </div>

    <div style="clear: both" ></div>

    <?php
    include('../footer.php');
    ?>

</div>

</body>

    </html><?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2016-01-02
 * Time: 14:27
 */