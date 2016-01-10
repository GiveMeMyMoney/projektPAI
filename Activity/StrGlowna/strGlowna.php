<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

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

debug_to_console($_COOKIE['id_sesja'] . "po");
debug_to_console($_COOKIE['id_uzytkownik'] . "po");

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

?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Strona Glowna</title>

    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" type="text/css" >

    <link rel="stylesheet" href="../../Style/styleStrGlowna.css" type="text/css" >
    <link rel="stylesheet" href="../../Fontello/css/fontello.css" type="text/css" >
    <link href='https://fonts.googleapis.com/css?family=Lato|Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <script src="../../zPomocnicze/timer.js"></script>

</head>

<body onload=czas();>
    <div id="container">
        <?php
            include('../header.php');
        ?>

        <?php
        include('../leftPanel.php');
        ?>


        <div class="rightPanel" >
            <div id="zegar"> <p>Obsługa systemu: </p></div>

            <h3>*Obsługa magazynów</h3>

            <p>1. W zakładce "Magazyny" możesz sprawdzić swoje aktualne magazyny.</p>
            <p>2. Możesz dodać jak i usunąć magazyn.</p>
            <p>3. Po wybraniu magazynu zostaniesz przeniesiony do wyboru Inwentaryzacji jakie zostały rozpoczęty w danym magazynie.</p>
            <p>4. Możesz również sprawdzić wszystkie swoje towary jakie posiada wybrany uprzednio magazyn.</p>

            <h3>*Obsługa towarów</h3>

            <p>1. W zakładce "Towary" możesz sprawdzić swoje aktualne towary przypisane do danego magazynu.</p>
            <p>2. Możesz dodać jak i usunąć towar.</p>
            <p>3. W tabelce sprawdzisz różne iformacje na temat towaru.
                Jeśli towar nie jest przypięty do żadnego arkusza spisowego zostaje wyświetlone "N/A",
                dotyczy to również stanu towaru w danym magazynie.</p>

            <h3>*Obsługa inwentaryzacji</h3>

            <p>1. W zakładce "Inwentaryzacja" możesz sprawdzić swoje aktualne arkusze inwentaryzacyjne przypisane do danego magazynu.</p>
            <p>2. Możesz dodać jak i usunąć arkusz.</p>
            <p>3. Po wybraniu inwentaryzacji zostaniesz przeniesiony do wyboru arkusz spisowego danej inwentaryzacji .</p>
            <p>4. Na kafelku arkusz zostaniesz poinformowany czy dany arkusz jest już zablokowany i nie można go edytować (zakończony).</p>
            <p>5. Możesz dodać jak i usunąć arkusz spisowy.</p>
            <p>6. Po wybraniu arkusza zostaniesz przeniesiony do listy towarów wybranych dla tego arkusza.</p>
            <p>7. Możesz dokonać sprawdzenia stanu danego towaru wpisując w odpowiednie pole i klikając "Wprowadź zmiany".</p>
            <p>8. Jeśli cztery pola w danym towarze są puste to znaczy że nikt jeszcze nie sprawdzxał jego stanu</p>
            <p>9. Możesz dodać i usunąć towar wybierając najpierw kategorię a później ustawiając odpowiednio check-boxy</p>
            <p>10. Zablokowanie arkusza jest możliwe pod przyciskiem "Zablokuj"
                (UWAGA! nie ma możliwości późniejszego powrotu do arkusza w celu bezpieczeństwa i brak ingerencji osób trzecich)</p>

            <h3>Życzymy miłego użytkowania w razie problemów zapraszamy do kontaktu. JunSOFT Company <i class="icon-emo-thumbsup"></i> </h3>

        </div>
        <div style="clear: both" ></div>


        <?php
            include('../footer.php');
        ?>

    </div>

</body>

</html>
