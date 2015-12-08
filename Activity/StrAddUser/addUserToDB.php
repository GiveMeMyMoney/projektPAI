<?php

session_start();

/*if((!isset($_POST['login2'])) || (!isset($_POST['haslo2']))) {
    header('Location: index.php');
    exit();
}*/

require_once ('../../BazaDanych/DBconnection.php');
$dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
//w oparciu o cookies

$login = $_POST['login2'];   //pobranie danych z HTMLa
$haslo = $_POST['haslo2'];
$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$telefon = $_POST['telefon'];
$email = $_POST['email'];
$data= $_POST['dataZatrudnienia'];

$login = htmlentities($login, ENT_QUOTES, "UTF-8"); //encje HTMLa by nikt nie wykonal jakiegos skryptu etc.
$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
$imie = htmlentities($imie, ENT_QUOTES, "UTF-8");
$nazwisko = htmlentities($nazwisko, ENT_QUOTES, "UTF-8");
$telefon = htmlentities($telefon, ENT_QUOTES, "UTF-8");
$email = htmlentities($email, ENT_QUOTES, "UTF-8");
$data= htmlentities($data, ENT_QUOTES, "UTF-8");

$options = [
    'cost' => 9,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];
$hashHaslo = password_hash($haslo, PASSWORD_BCRYPT, $options);

if (mysqli_query($dbconn, sprintf("CALL add_user('%s', '%s', '%s', '%s', '%s', '%s', '%s')", mysqli_real_escape_string($dbconn, $login),
    mysqli_real_escape_string($dbconn, $hashHaslo), mysqli_real_escape_string($dbconn, $imie),
    mysqli_real_escape_string($dbconn, $nazwisko), mysqli_real_escape_string($dbconn, $telefon),
    mysqli_real_escape_string($dbconn, $email), mysqli_real_escape_string($dbconn, $data)))) {
    header('Location: ../StrLogowanie/index.php');
} else {
    debug_to_console("AddUserToDB: nie dodalo uzytkownika do BD");
    echo "error"." Describe: "."cos poszlo nie tak przy dodawaniu usera do BD"; //do zmiany na jakis wyjatek?
}

$dbconn->close();

?>
