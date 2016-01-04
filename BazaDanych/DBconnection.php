<?php
/**
 * Plik sluzacy do laczenia z Baza Danych mySQL.
 */

function getConnection()
{
    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpass = 'Mieszko623169';
    $dbname = 'projekt_pai';
    $dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die('cannot connect to DB');
    $dbconn->set_charset("utf8");

    return $dbconn;
}

//metoda do debugu w konsoli
function debug_to_console( $data ) {
    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    echo $output;
}
?>


<!--class Database
{
    private static $instance;
    private static $dbhost = 'localhost:3306';
    private static $dbuser = 'root';
    private static $dbpass = 'Mieszko623169';
    private static $dbname = 'projekt_pai';

    private $dbconn;

    private function __construct()
    {
        $this->dbconn = new mysqli(self::$dbhost, self::$dbuser, self::$dbpass, self::$dbname);
        if (mysqli_connect_errno()) {
            debug_to_console("Connect failed: %s\n" . mysqli_connect_error());
            exit();
        }
    }

    function __destruct() {
        $this->dbconn->close();
    }

    public static function getConnection() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance->dbconn;
    }


//metoda do debugu w konsoli

}-->

<!--//using mysqli
/*$dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($dbconn->connect_errno!=0) {
echo "Error: ".$dbconn->connect_errno;
}*/


/**
* Funkcja sluzaca do debugu do konsoli.
* @param $data - String
*/
/*function debug_to_console( $data ) {
if ( is_array( $data ) )
$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
else
$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

echo $output;
}*/

//using PDO
/*try {
$dbconn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

//$count = $dbconn->exec("INSERT INTO uzytkownicy(`_id`, a, v, s, c, z, aa, aaaa)  VALUES (22323,2,2,2,2,22,2,2)");

}
catch(PDOException $e)
{
echo $e->getMessage();
}*/-->
