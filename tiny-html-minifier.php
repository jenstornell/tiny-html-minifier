<?php
class TinyHtmlMinifier {
    function __construct() {
        $this->elements = $this->elements();
        $this->elementsSkipSpace = $this->elementsSkipSpace();
        $this->elementsSkipAll = $this->elementsSkipAll();
    }

    // Minify
    function minify($html) {
        $html = str_replace("\r", "\n", $html);
        $html = preg_replace('/<!\[cdata\[(.*?)\]\]>/is', '', $html);
        $html = $this->parser($html);
        
        return $html;
    }

    // Parser loop
    function parser($html) {
        $split = explode('<', $html);
        $html = '';

        foreach($split as $part) {
            if($part == '') continue;

            $name = $this->getName($part);
            $element = $this->partToElement($part);

            $html .= $this->minifyHtml($name, $element);
        }

        return $html;
    }

    // Convert part to an element
    function partToElement($part) {
        return '<' . $part;
    }

    // Minify
    function minifyHtml($name, $element) {
        // No name
        if($name == '') {                               return trim($element);
        } elseif($this->isElementClosed($name)) {       return $this->minifyElementClosed($name, $element);
        } elseif($this->isElement($name)) {             return $this->strip($element);
        } elseif($this->isComment($name)) {             return $this->removeComment($element);
        } elseif($this->isElementSkipSpace($name)) {    return $this->stripSkipSpace($element);
        } elseif($this->isElementSkipAll($name)) {      return $element;
        } else {                                        return $this->stripSkipNewlines($element); }
    }

    // Is comment
    function isComment($name) {
        return ($name == '!--') ? true : false;
    }

    // Remove comment
    function removeComment($element) {
        $position = strpos($element, '-->');
        $element = substr($element, $position + 3);
        return $this->stripSkipSpace($element);
    }

    // Is style
    function isStyle($name) {
        return ($name == 'style') ? true : false;
    }

    // Is element closed
    function isElementClosed($name) {
        return (substr($name, 0, 1) == '/') ? true : false;
    }

    // Is element
    function isElement($name) {
        return (in_array($name, $this->elements)) ? true : false;
    }

     // Is element space
     function isElementSkipSpace($name) {
        return (in_array($name, $this->elementsSkipSpace)) ? true : false;
    }

    // Is element skip all
    function isElementSkipAll($name) {
        return (in_array($name, $this->elementsSkipAll)) ? true : false;
    }

    // Get name from element
    function getName($element) {
        $space = $this->splitByDelimiter(' ', $element);
        $close = $this->splitByDelimiter('>', $element);

        $name = (strlen($space) < strlen($close)) ? $space : $close;
        return strtolower($name);
    }

    // Limit string by a character
    function splitByDelimiter($delimiter, $element) {
        $position = strpos($element, $delimiter);
        $split = substr($element, 0, $position);
        return $split;
    }

    // Name to nicename
    function nicename($name) {
        $nicename = substr($name, 1);
        return $nicename;
    }

    /* Minify */

    // Minify closed element
    function minifyClosedElement($name, $element) {
        if($this->isElement($this->nicename($name)))
            return $this->strip($element);
        return $element;
    }

    // Minify closed element keep space
    function minifyClosedElementKeepSpaces($name, $element) {
        $nicename = $this->nicename($name);
        if($this->isElementSkipSpace($nicename) || $this->isElementSkipAll($nicename))
            return $this->stripSkipSpace($element);
        return $element;
    }

    // Minify element closed
    function minifyElementClosed($name, $element) {
        $element = $this->minifyClosedElement($name, $element);
        $element = $this->minifyClosedElementKeepSpaces($name, $element);
        return $element;
    }

    /* Strip */

    // Minify as much as possible
    function strip($element) {
        $element = preg_replace('!\s+!', ' ', $element);
        $element = str_replace("> ", ">", $element);
        return trim($element);
    }

    // Minify but keep one space
    function stripSkipSpace($element) {
        return preg_replace('!\s+!', ' ', $element);
    }

    // Minify by preserving rows
    function stripSkipNewlines($element) {
        $rows = explode("\n", $element);
        $html = '';
        foreach($rows as $part) {
            $html .= trim($part) . "\n";
        }
        return $html;
    }

    /* Elements */

    // Elements to array
    function elementsToArray($elements) {
        $trim = str_replace(["\n", "\r"], ["", ""], $elements);
        return array_filter(explode(' ', $trim));
    }

    // Elements as rows
    function elementsSkipAll() {
        $elements = '
            code pre textarea
        ';
        return $this->elementsToArray($elements);
    }

    function elementsSkipSpace() {
        $elements = '
            !doctype
            a abbr address area article aside audio
            b base bdi bdo blockquote body br button
            canvas caption cite col colgroup
            datalist dd del details dfn div dialog dl dt
            em embed
            fieldcaption fieldset figure footer form
            h1 h2 h3 h4 h5 h6
            hr head header html
            i img
            li
            main mark menu menuitem meta meter
            nav noscript
            object ol optgroup option output
            p param picture progress
            q
            rp rt ruby
            s samp span section select small source strong sub summery
            table tbody td tfoot th thead time title tr track
            u ul
            var vbr video
        ';
        return $this->elementsToArray($elements);
    }

    // Elements
    function elements() {
        $elements = '
            !doctype body head html meta title link
        ';

        $elements .= '
            style
        ';

        $elements .= '
            svg path
        ';
        return $this->elementsToArray($elements);
    }
}

class TinyMinify {
    static function html($html) {
        $minifier = new TinyHtmlMinifier();
        return $minifier->minify($html);
    }
}