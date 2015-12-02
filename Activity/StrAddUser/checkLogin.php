<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
require_once ('../../BazaDanych/DBconnection.php');

    /*$connnectionDB = new mysqli($dbhost,$dbuser,$db_password,$db_name);*/
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
                echo "*Login zajety!";
                $records->close();
            }else{
                error_log(print_r("Login poprawny: " . $login, TRUE));
            }
        }
        $dbconn->close();
    }
?>
</body>
</html>