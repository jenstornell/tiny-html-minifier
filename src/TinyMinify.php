<?php

// TODO: use namespace:
// namespace Minifier;
// use Minifier\TinyHtmlMinifier;

require 'TinyHtmlMinifier.php';

class TinyMinify
{
    public static function html(string $html, array $options = []) : string
    {
        $minifier = new TinyHtmlMinifier($options);
        return $minifier->minify($html);
    }
    public static function minifyCurrentFile(){
        ob_start(function($buffer){
            return TinyMinify::html($buffer);
         });
    }
}
