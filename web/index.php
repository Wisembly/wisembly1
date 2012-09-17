<?php

function url_exists($url) {
    $ch = @curl_init($url);
    @curl_setopt($ch, CURLOPT_HEADER, TRUE);
    @curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $status = array();
    preg_match('/HTTP\/.* ([0-9]+) .*/', @curl_exec($ch) , $status);

    return isset($status[1]) && $status[1] == 200;
}

function url_redirect($url, $header = true)
{
    if ($header) {
        header('HTTP/1.1 301 Moved Permanently', false, 301);
    }

    header("Location: {$url}");
    die();
}

$url = $_SERVER["REQUEST_URI"];
$host = $_SERVER["HTTP_HOST"];

if ('/' === $url) {
    url_redirect('fr');
} else {
    if (url_exists($host . '/fr' . $url)) {
        url_redirect('http://' . $host . '/fr' . $url);
    } elseif (url_exists($host . '/en' . $url)) {
        url_redirect('http://' . $host . '/en' . $url);
    }

    url_redirect('404.html', false);
}

die();