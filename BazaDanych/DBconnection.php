<?php
/**
 * Plik sluzacy do laczenia z Baza Danych mySQL.
 */

static $dbhost = 'localhost:3306';
static $dbuser = 'root';
static $dbpass = 'Mieszko623169';
static $dbname = 'projekt_pai';

    //using mysqli
    $dbconn = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if($dbconn->connect_errno!=0) {
        echo "Error: ".$dbconn->connect_errno;
    }

    //using PDO
   /*try {
       $dbconn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

       //$count = $dbconn->exec("INSERT INTO uzytkownicy(`_id`, a, v, s, c, z, aa, aaaa)  VALUES (22323,2,2,2,2,22,2,2)");

   }
   catch(PDOException $e)
   {
       echo $e->getMessage();
   }*/

?>