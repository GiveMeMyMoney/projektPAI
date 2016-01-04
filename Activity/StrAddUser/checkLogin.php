<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
require_once ('../../BazaDanych/DBconnection.php');

    $dbconn = getConnection();
    if($dbconn->connect_errno != 0){
        echo "error".$dbconn->connect_errno." Describe: ".$dbconn->connect_error;
    }
    else{
        $login = $_POST['login2'];
        $login = htmlentities($login, ENT_QUOTES, "UTF-8"); //encje HTMLa by nikt nie wykonal jakiegos sksryptu etc.
        if($records = @$dbconn->query(sprintf("SELECT * FROM uzytkownik WHERE uzk_login = '%s'", mysqli_real_escape_string($dbconn,$login))))
        {
            $counts = $records->num_rows;
            if($counts == 1){
                echo "*Login zajęty!";
                $records->close();
            }else{
                debug_to_console("Login poprawny: " . $login);
            }
        }
        $dbconn->close();
    }
?>
</body>
</html>