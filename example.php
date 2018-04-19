<?php
require 'tiny-html-minifier.php';

$html = file_get_contents(__DIR__ . '/tests/tests.html');

echo TinyMinify::html($html, [
    'collapse_json_ld' => true
]);