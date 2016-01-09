<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2016-01-06
 * Time: 22:14
 */
class Stan {
    private $stanId;
    private $pelnowartosciowe;
    private $uszkodzone;
    private $zniszczone;
    private $przeterminowane;

    public function __construct($stanId, $pelnowartosciowe, $uszkodzone, $zniszczone, $przeterminowane)
    {
        $this->stanId = $stanId;
        $this->pelnowartosciowe = $pelnowartosciowe;
        $this->uszkodzone = $uszkodzone;
        $this->zniszczone = $zniszczone;
        $this->przeterminowane = $przeterminowane;
    }

    //GETTERs and SETTERs
    public function getStanId()
    {
        return $this->stanId;
    }
    public function setStanId($stanId)
    {
        $this->stanId = $stanId;
    }
    public function getPelnowartosciowe()
    {
        return $this->pelnowartosciowe;
    }
    public function setPelnowartosciowe($pelnowartosciowe)
    {
        $this->pelnowartosciowe = $pelnowartosciowe;
    }
    public function getUszkodzone()
    {
        return $this->uszkodzone;
    }
    public function setUszkodzone($uszkodzone)
    {
        $this->uszkodzone = $uszkodzone;
    }
    public function getZniszczone()
    {
        return $this->zniszczone;
    }
    public function setZniszczone($zniszczone)
    {
        $this->zniszczone = $zniszczone;
    }
    public function getPrzeterminowane()
    {
        return $this->przeterminowane;
    }
    public function setPrzeterminowane($przeterminowane)
    {
        $this->przeterminowane = $przeterminowane;
    }
}

require_once "../../BazaDanych/DBconnection.php";

if (isset($_POST['inwentStan'])) {
    $arrStanID = $_POST['inwentStan'];
    $arrInwentPelnowartosciowe = $_POST['nrPelnowartosciowe'];
    $arrInwentUszkodzone = $_POST['nrUszkodzone'];
    $arrInwentZniszczone = $_POST['nrZniszczone'];
    $arrInwentPrzeterminowane = $_POST['nrPrzeterminowane'];

    /*var_dump($arrStanID);
    var_dump($arrInwentPelnowartosciowe);
    var_dump($arrInwentUszkodzone);
    var_dump($arrInwentZniszczone);
    var_dump($arrInwentPrzeterminowane);*/

    for ($iter = 0; $iter < count($arrStanID); $iter++) {
        $stan = new Stan($arrStanID[$iter], $arrInwentPelnowartosciowe[$iter], $arrInwentUszkodzone[$iter], $arrInwentZniszczone[$iter], $arrInwentPrzeterminowane[$iter]);
        if ($stan->getPelnowartosciowe() != null || $stan->getUszkodzone() != null || $stan->getZniszczone() != null || $stan->getPrzeterminowane() != null) {
            var_dump("sprawdzam nulle");
            $idStan = $stan->getStanId();
            $pelnowartosciowe = $stan->getPelnowartosciowe();
            if ($pelnowartosciowe == null) {
                $pelnowartosciowe = 0;
            }
            $uszkodzone = $stan->getUszkodzone();
            if ($uszkodzone == null) {
                $uszkodzone = 0;
            }
            $zniszczone = $stan->getZniszczone();
            if ($zniszczone == null) {
                $zniszczone = 0;
            }
            $przeterminowane = $stan->getPrzeterminowane();
            if ($przeterminowane == null) {
                $przeterminowane = 0;
            }
            $dbconn = getConnection();
            $result = mysqli_query($dbconn, "UPDATE stan_rzeczywisty SET stan_pelnowartosciowe = '$pelnowartosciowe', stan_uszkodzone = '$uszkodzone',
                stan_zniszczone = '$zniszczone', stan_przeterminowane = '$przeterminowane' WHERE stan_id = '$idStan';");
            if ($result) {
                /*var_dump("zaktualizacjowano " . $idStan);*/
            } else {
                debug_to_console("jakis problem");
            }

            $dbconn->close();
        }


    }
}

header('Location: towaryArkusz.php');

?>