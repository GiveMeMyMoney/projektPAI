<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2016-01-09
 * Time: 19:39
 */

function usunCookies()
{
    setcookie("id_magazyn", null, time()-3600, '/');
    unset($_COOKIE['id_magazyn']);
    $_COOKIE['id_magazyn'] = null;

    setcookie("id_inwentaryzacji", null, time()-3600, '/');
    unset($_COOKIE['id_inwentaryzacji']);
    $_COOKIE['id_inwentaryzacji'] = null;

    setcookie("id_arkusza", null, time()-3600, '/');
    unset($_COOKIE['id_arkusza']);
    $_COOKIE['id_arkusza'] = null;

    setcookie("id_kategoria", null, time()-3600, '/');
    unset($_COOKIE['id_kategoria']);
    $_COOKIE['id_kategoria'] = null;
}
