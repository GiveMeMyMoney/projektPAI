<?php

session_start();

//wyczyszczenie cache strony. - dodawac do kazdego pliku
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//jezeli ktos nie wpisal nic w login albo haslo przekierowuje znowu (dodatkowe zabezpieczenie)
if((!isset($_POST['login'])) || (!isset($_POST['haslo']))) {
    header('Location: index.php');
    exit();
}

require_once "../../BazaDanych/DBconnection.php";
$dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($dbconn->connect_errno!=0) {
    echo "Error: ".$dbconn->connect_errno;
} else {
    $login = $_POST['login'];   //pobranie danych z HTMLa
    $haslo = $_POST['haslo'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8"); //encje HTMLa by nikt nie wykonal jakiegos sksryptu etc.
    $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

    debug_to_console("wchodze 1");

    if($records = mysqli_query($dbconn, sprintf("SELECT * FROM uzytkownik WHERE uzk_login = '%s';", mysqli_real_escape_string($dbconn, $login)))) {
        debug_to_console("Wchodzi 2");
        $count1 = $records->num_rows;   //zliczanie ilosci prawidlowych zapytan
        if($count1 > 0) {
            debug_to_console("Wchodzi 3");
            $wiersz = $records->fetch_assoc();  //tworzenie tablicy asocjacyjnej
            $hashHaslo = $wiersz['uzk_haslo'];  //pobieranie zahashowanego hasla z BD
            if (password_verify($haslo, $hashHaslo)) {
                /**
                 * Zmienne sesyjne jako flagi by rozpoznac blad.
                 */
                $_SESSION['bladSQL'] = false;
                $_SESSION['bladHasla'] = false;
                $_SESSION['bladLoginu'] = false;

                debug_to_console("Wchodzi 4");

                $id_sesja = md5(rand(-100,100) . microtime()) . md5(crc32(microtime()) . $_SERVER['REMOTE_ADDR']);
                $ip = $_SERVER['REMOTE_ADDR'];
                $web = $_SERVER['HTTP_USER_AGENT'];
                $id_uzyt = $wiersz['uzk_id'];
                //sprawdzam czy juz taki id_uzk nie ma w SESJA
                if ($checkRecords = mysqli_query($dbconn, sprintf("SELECT * FROM sesja WHERE ses_uzk_id = '%s';", mysqli_real_escape_string($dbconn,$id_uzyt)))) {
                    debug_to_console("Wchodzi 4 i 1pol");
                    //mysqli_query($dbconn, sprintf("INSERT INTO test VALUES (NULL, '%s');",
                       // mysqli_real_escape_string($dbconn, 'niach3')));
                    $count2 = $checkRecords->num_rows;
                    if ($count2 > 0) {
                        debug_to_console("Wchodzi 4 i 11111pol");
                        //usuwanie tego rekordu z TABELI sesja
                        mysqli_query($dbconn, sprintf("CALL usun_sesje('%s');", mysqli_real_escape_string($dbconn, $id_uzyt)));
                        mysqli_query($dbconn, "insert into sesja (ses_uzk_id, ses_id, ses_ip, ses_web)
                                                values ('$id_uzyt','$id_sesja','$ip','$web')");
                        if (!mysqli_errno($dbconn)){
                            debug_to_console("Wchodzi 5");
                            debug_to_console("ID_SESJI_ZMIENNA: " . $id_sesja);
                            setcookie('id_sesja', $id_sesja, time()+3600, "/");
                            $_COOKIE['id_sesja'] = $id_sesja;   //natychmiastowe ustawienie cookiesa, bez przeladowania.
                            setcookie('id_uzytkownik', $id_uzyt, time()+3600, "/");
                            $_COOKIE['id_uzytkownik'] = $id_uzyt;
                            debug_to_console($_COOKIE['id_sesja']);
                            debug_to_console($_COOKIE['id_uzytkownik']);
                        } else {
                            debug_to_console("błąd podczas logowania1!");
                            $_SESSION['bladSQL'] = true;
                            header('Location: index.php');
                        }
                    } else {
                        debug_to_console("Wchodzi 4 i 2pol");
                        mysqli_query($dbconn, sprintf("INSERT INTO test VALUES (NULL, '%s');",
                            mysqli_real_escape_string($dbconn, 'niach14242')));
                        mysqli_query($dbconn, sprintf("INSERT INTO sesja (ses_uzk_id, ses_id, ses_ip, ses_web)
                        VALUES ('%s', '%s', '%s', '%s')",
                            mysqli_real_escape_string($dbconn, $id_uzyt),
                            mysqli_real_escape_string($dbconn, $id_sesja),
                            mysqli_real_escape_string($dbconn, $ip),
                            mysqli_real_escape_string($dbconn, $web)
                        ));
                        if (!mysqli_errno($dbconn)){
                            setcookie('id_sesja', $id_sesja, time()+3600, "/");
                            $_COOKIE['id_sesja'] = $id_sesja;
                            setcookie('id_uzytkownik', $id_uzyt, time()+3600, "/");
                            $_COOKIE['id_uzytkownik'] = $id_uzyt;
                        } else {
                            debug_to_console("błąd podczas logowania2!");
                            $_SESSION['bladSQL'] = true;
                            header('Location: index.php');
                        }
                    }
                }
                $records->close();
                header("location: ../StrGlowna/strGlowna.php");

            } else {
                if (isset($_COOKIE['id_uzytkownik']) || isset($_COOKIE['id_sesja'])) {
                    setcookie('id_uzytkownik', null, time() - 1, '/');
                    unset($_COOKIE['id_uzytkownik']);
                    setcookie('id_sesja', null, time() - 1, '/');
                    unset($_COOKIE['id_sesja']);
                }
                $_SESSION['bladHasla'] = true;
                $records->close();
                //header('Location: index.php');
            }
        } else {
            if (isset($_COOKIE['id_uzytkownik']) || isset($_COOKIE['id_sesja'])) {
                setcookie('id_uzytkownik', null, time() - 1, '/');
                unset($_COOKIE['id_uzytkownik']);
                setcookie('id_sesja', null, time() - 1, '/');
                unset($_COOKIE['id_sesja']);
            }
            $_SESSION['bladLoginu'] = true;
            $records->close();
            //header('Location: index.php');
        }
    }
    $dbconn->close();
}
?>

<!--= @$dbconn->query(
sprintf("SELECT * FROM uzytkownik WHERE uzk_login = '%s' AND uzk_haslo = '%s'",
mysqli_real_escape_string($dbconn, $login), //zabezpiecznie przed SQL injection(m.in -- '' i inne)
mysqli_real_escape_string($dbconn, $haslo)))-->