<?php

session_start();

if((!isset($_POST['login'])) || (!isset($_POST['haslo']))) {
    header('Location: index.php');
    exit();
}

require_once ('../../BazaDanych/DBconnection.php');

/*$dbconn->quote($_POST['login']);*/
$login = $_POST['login'];   //pobranie danych z HTMLa
$haslo = $_POST['haslo'];

$login = htmlentities($login, ENT_QUOTES, "UTF-8"); //encje HTMLa by nikt nie wykonal jakiegos sksryptu etc.
$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

$records = mysqli_query($dbconn, sprintf("CALL login('%s')", mysqli_real_escape_string($dbconn, $login)));
                                        //zabezpiecznie przed SQL injection(m.in -- '' i inne)

if($records) {
    $counts = $records->num_rows;   //zliczanie ilosci prawidlowych zapytan
    if($counts > 0) {
        $wiersz = $records->fetch_assoc();  //tworzenie tablicy asocjacyjnej
        $hashHaslo = $wiersz['uzk_haslo'];
        if (password_verify($haslo, $hashHaslo)) {
            $_SESSION['zalogowany'] = true; //flaga
            $_SESSION['id_uzytkownika'] = $wiersz['uzk_id'];
            $_SESSION['uzytkownik'] = $wiersz['uzk_login']; //zapisywanie do globalnej tablicy session uzytkownika
            unset($_SESSION['blad']);
            $_SESSION['blad'] = false;
            $records->free_result();
            header('Location: ../StrGlowna/strGlowna.php');   //przekierowanie do innego pliku.
        } else {
            $_SESSION['zalogowany'] = false; //flaga
            $_SESSION['bladHasla'] = true;
            header('Location: index.php');
        }

    } else {
        $_SESSION['zalogowany'] = false; //flaga
        $_SESSION['bladLoginu'] = true;
        header('Location: index.php');
    }
}
$dbconn->close();


?>

<!--= @$dbconn->query(
sprintf("SELECT * FROM uzytkownik WHERE uzk_login = '%s' AND uzk_haslo = '%s'",
mysqli_real_escape_string($dbconn, $login), //zabezpiecznie przed SQL injection(m.in -- '' i inne)
mysqli_real_escape_string($dbconn, $haslo)))-->