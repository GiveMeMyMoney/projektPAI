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


function displayKategoria($idKat, $nazwa)
{
    echo '<div class="col-lg-4">';
    echo '<a href="towaryMagazyn.php" onclick="sprawdzKategoria(' . $idKat . ');" class="tilelink">';
        echo '<div class="kategoriaTile" >';

            echo '<div style="text-align: center;">';
            echo '<i class="icon-box"></i> <br/>';
            echo $nazwa . "<br/>";
            echo '</div>';

        echo '</div>';
    echo '</a>';
    echo '</div>';

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

    <div style="float:right; width: 70%;">


        <?php
        $dbconn = getConnection();
        $result = mysqli_query($dbconn, "SELECT * FROM kategoria_towaru;");
        $count = $result->num_rows;

        if ($count>0) {
            echo '<div class="row">';
            for ($iter = 0; $wierszKategoria = mysqli_fetch_array($result);) {
                displayKategoria($wierszKategoria['kt_id'], $wierszKategoria['kt_nazwa']);


                //displayKategoria($wierszKategoria['kt_id'], $wierszKategoria['kt_nazwa'], $wierszKategoria['kt_opis']);
                //displayKategoria($wierszKategoria['kt_id'], $wierszKategoria['kt_nazwa'], $wierszKategoria['kt_opis']);

                $iter++;
                if (($iter % 3) == 0) {
                    echo '</div><div class="row">';
                }

            }
            echo '</div>';
        } else {
            echo '<div style="margin: 20px; color: red">';
            echo '*Brak aktualnych kategorii';
            echo '</div>';
        }


        ?>

        <!-- Trigger the modal with a button -->
        <button style="float: right; margin: 15px;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Dodaj kategorie</button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Nowa Kategoria</h2>
                    </div>
                    <div class="modal-body">
                        <p>Wprowadź dane:</p>
                        <form action="addKategoriaToDB.php" method="post">
                            Nazwa: <input type="text" maxlength="28" name="nazwa" required  /> <br>
                            Opis(opcjonalnie): <input type="text" name="opis" /> <br>
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

    </html><?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2016-01-02
 * Time: 14:27
 */