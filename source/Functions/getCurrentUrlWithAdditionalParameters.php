<?php

namespace Objement\OmPhpUtils\Functions;

function getCurrentUrlWithAdditionalParameters($additionalQueryString): string
{
    $url = sprintf("%s://%s%s%s", $_SERVER['HTTPS'] && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http', $_SERVER['HTTP_HOST'], !empty($_SERVER['SERVER_PORT']) ? ':' . $_SERVER['SERVER_PORT'] : '', $_SERVER['REQUEST_URI']);
    $urlParsed = parse_url($url);
    $newQSParsed = [];
    if ($urlParsed && isset($urlParsed['query'])) {
        parse_str($urlParsed['query'], $newQSParsed);
    }
    $otherQueryString = $additionalQueryString ?? '';
    if ($otherQueryString && $otherQueryString[0] == '?') {
        $otherQueryString = substr($otherQueryString, 1);
    }
    $otherQSParsed = array();
    parse_str($otherQueryString, $otherQSParsed);
    $finalQueryStringArray = array_merge($newQSParsed, $otherQSParsed);
    $finalQueryString = http_build_query($finalQueryStringArray);

    return sprintf("%s://%s%s%s", $urlParsed['scheme'], $urlParsed['host'], $urlParsed['path'], $finalQueryString ? '?' . $finalQueryString : '');
}