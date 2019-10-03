<?php

// TODO: use namespace:
// use Minifier\TinyMinify;

require '../src/TinyMinify.php';

$html = file_get_contents(__DIR__ . '/tests.html');

$htmlMinify = TinyMinify::html($html);

var_dump($htmlMinify);