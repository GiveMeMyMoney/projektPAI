<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2015-12-26
 * Time: 15:38
 */

function debug_to_console( $data ) {
    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

?>