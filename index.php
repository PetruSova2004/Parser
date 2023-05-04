<?php

$url = 'https://www.siliconeintakes.com/';

function getUrl(string $url): string
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36");

    return curl_exec($ch);
}

$html = getUrl($url);
preg_match_all("/<a href=\"([^\"]+?)\"><img src=\".+?\" alt=\".+?\"><span>(.+?)<\/span><\/a>/is", $html, $matches); // находим все вхождения на странице
//print_r($matches);

foreach ($matches[1] as $url) { // открываем массив адрессов
    $html = getUrl($url);

    preg_match_all("/<a class=plistname href=\"([^\"]+?)\">(.+?)<\/a>/is", $html, $mathcesProducts);
//    print_r($mathces);
    foreach ($mathcesProducts[1] as $urlProduct) {
        $html = getUrl($urlProduct);

        preg_match("/<h1>(.+?)<\/h1>/is", $html, $matchProduct);
        preg_match("/<div class=\"content\">(.+?)<\/div>/is", $html, $matchDescription);
        preg_match("/<a href=\"([^\"]+?)\" data-lightbox=\"pimages\">/is", $html, $matchImage);

        echo 'Product: ' . $matchProduct[1] . PHP_EOL;
        echo 'Description: ' . $matchDescription[1] . PHP_EOL;
        echo 'Image: ' . $url . $matchImage[1] . PHP_EOL;
    }
}