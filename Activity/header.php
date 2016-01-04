<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2015-12-26
 * Time: 13:20
 */

?>

<div id="header">
    <div class="tytul">
        <?php
        $wierszUzytkownik = mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT * FROM uzytkownik WHERE
                        uzk_id = '$wierszSesja[ses_uzk_id]';"));
        if (!mysqli_errno($dbconn) && !empty($wierszUzytkownik['uzk_id'])){
            echo "Witaj " . $wierszUzytkownik['uzk_imie'] . " " . $wierszUzytkownik['uzk_nazwisko'] . "!";
        } else {
            debug_to_console("błąd podczas pobierania uzytkownika o ID: " . $wierszUzytkownik['uzk_id']);
            $_SESSION['bladSQL'] = true;
            header('Location: index.php');
        }

        $dbconn->close();
        ?>
    </div>
    <div class="dane">
        <?php
        if(isset($_COOKIE['id_magazyn']) && $_COOKIE['id_magazyn'] != null){
            $dbconn = getConnection();
            $wierszMagazyn = mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT mag_nazwa FROM magazyn WHERE mag_id = '$_COOKIE[id_magazyn]';"));
            echo 'Magazyn: ' . $wierszMagazyn['mag_nazwa'];
            $dbconn->close();
        } else {
            echo '<a href="../Magazyn/magazyn.php" class="tilelink">Wybierz magazyn</a>';
        }
        ?>
    </div>
    <div class="wyloguj">
        <a href = "../StrLogowanie/logOut.php"> Wyloguj</a>
    </div>
    <div style="clear: both" > </div>
</div>



<!--Magazyn
<script type="text/javascript" src="../cookieScript/cookies.js"></script>
<script>
    var idMagazyn = retrieve_cookie('id_magazynu');
    var infoMagazyn = document.getElementById("magazyn");
    infoMagazyn.innerHTML = '<b>Wypełnij oba pola z hasłem!</b>';

    if(idMagazyn != null && idMagazyn != '') {

/*        $dbconn = getConnection();
        $wierszMagazyn = mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT mag_nazwa FROM magazyn WHERE mag_id = '$_COOKIE[id_magazyn]';"));

        echo 'Magazyn: ' . $wierszMagazyn['mag_nazwa'];

        $dbconn->close();
        */
    } else {

/*            echo 'dasdasdas';
            echo '<a href="../Magazyn/magazyn.php" class="tilelink">Wybierz magazyn</a>'
        */
    }

</script>-->