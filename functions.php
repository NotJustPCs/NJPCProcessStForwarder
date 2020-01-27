<?php

function redirect($url)
{
    $string = '<script type="text/javascript">';
    $string .= 'await sleep(10000);';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';

    echo $string;
}

function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

?>
