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
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

// redirect here if we have a known domain
if (false !== strpos($host, '.fr')) {
    url_redirect("http://wisembly.com/fr{$url}");
} elseif (false !== strpos($host, '.es') && url_exists("http://wisembly.com/es{$url}")) {
    url_redirect("http://wisembly.com/es{$url}");
} elseif (false !== strpos($host, '.de') && url_exists("http://wisembly.com/de{$url}")) {
    url_redirect("http://wisembly.com/de{$url}");
} elseif (false !== strpos($host, '.ch') && url_exists("http://wisembly.com/fr{$url}")) {
    url_redirect("http://wisembly.com/ch{$url}");
}

// redirect here depending on user browser language if on wisembly.com/
if ('/' === $url) {
    if (url_exists("http://{$lang}{$url}")) {
        url_redirect("http://{$host}/{$lang}{$url}");
    }

url_redirect("http://wisembly.com/en/");
}

// redirect here if direct wisembly full url on .com
if (url_exists($host . '/fr' . $url)) {
    url_redirect('http://' . $host . '/fr' . $url);
} elseif (url_exists($host . '/en' . $url)) {
    url_redirect('http://' . $host . '/en' . $url);
} elseif (url_exists($host . '/es' . $url)) {
  url_redirect('http://' . $host . '/es' . $url);
} elseif (url_exists($host . '/de' . $url)) {
  url_redirect('http://' . $host . '/de' . $url);
}

// after all that, did not find your page?? DAMN!
url_redirect('404.html', false);

die();