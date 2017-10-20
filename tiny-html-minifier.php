<?php
class TinyHtmlMinifier {
    function __construct() {
        $this->elements_compact = $this->elementsAsCompact();
        $this->elements_rows = $this->elementsAsRows();
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
        if($name == '')
            return trim($element);
        elseif($this->isElementClosed($name) || $this->isElementCompact($name))
            return $this->minifySpace($element);
        elseif($this->isComment($name)) {
            return $this->removeComment($element);
        } elseif($this->isStyle($name))
            return $this->minifyCompact($element);
        elseif($this->isElementRow($name)) {
            return $element;
        } else
            return $this->minifyRows($element);
    }

    // Is comment
    function isComment($name) {
        return ($name == '!--') ? true : false;
    }

    // Remove comment
    function removeComment($element) {
        $position = strpos($element, '-->');
        $element = substr($element, $position + 3);
        return $this->minifySpace($element);
    }

    // Is style
    function isStyle($name) {
        return ($name == 'style') ? true : false;
    }

    // Is element closed
    function isElementClosed($name) {
        return (substr($name, 0, 1) == '/') ? true : false;
    }

    // Is element compact
    function isElementCompact($name) {
        return (in_array($name, $this->elements_compact)) ? true : false;
    }

    // Is element row
    function isElementRow($name) {
        return (in_array($name, $this->elements_rows)) ? true : false;
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

    // Minify as much as possible
    function minifyCompact($element) {
        $element = preg_replace('!\s+!', ' ', $element);
        $element = str_replace("> ", ">", $element);
        return $element;
    }

    // Minify but keep one space
    function minifySpace($element) {
        return preg_replace('!\s+!', ' ', $element);
    }

    // Minify by preserving rows
    function minifyRows($element) {
        $rows = explode("\n", $element);
        $html = '';
        foreach($rows as $part) {
            $html .= trim($part) . "\n";
        }
        return $html;
    }

    // Elements to array
    function elementsToArray($elements) {
        return explode(',', str_replace(["\n", "\r", " "], ["", "", ""], $elements));
    }

    // Elements as rows
    function elementsAsRows() {
        $elements = '
            address, code, pre, textarea,
        ';

        return $this->elementsToArray($elements);
    }

    // Elements as compact
    function elementsAsCompact() {
        $elements = '
            !doctype,
            a, abbr, area, article, aside, audio,
            b, base, bdi, bdo, blockquote, body, br, button,
            canvas, caption, cite, col, colgroup,
            datalist, dd, del, details, dfn, div, dialog, dl, dt,
            em, embed,
            fieldcaption, fieldset, figure, footer, form,
            h1, h2, h3, h4, h5, h6,
            hr, head, header, html,
            i, img,
            li, link,
            main, mark, menu, menuitem, meta, meter,
            nav, noscript,
            object, ol, optgroup, option, output,
            p, param, picture, progress,
            q,
            rp, rt, ruby,
            s, samp, span, section, select, small, source, strong, sub, summery,
            table, tbody, td, tfoot, th, thead, time, title, tr, track,
            u, ul,
            var, vbr, video,
        ';

        $elements .= '
            svg,
            path,
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