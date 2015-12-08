<?php
/**
 * Plik sluzacy do laczenia z Baza Danych mySQL.
 */

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = 'Mieszko623169';
$dbname = 'projekt_pai';

//metoda do debugu w konsoli
function debug_to_console( $data ) {
    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

?>


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
