<?php
class TinyHtmlMinifier {
    function __construct($options) {
        $this->options = $options;
        $this->build = [];
        $this->skip = 0;
        $this->skipName = '';
        $this->head = false;
        $this->elements = [
            'skip' => [
                'code',
                'pre',
                'textarea',
                'script'
            ],
            'hard' => [
                '!doctype',
                'body',
                'html',
            ]
        ];
    }

    // Run minifier
    function minify($html) {
        $html = $this->removeComments($html);
        $this->walk($html);
        return $this->buildHtml();
    }

    // Walk trough html
    function walk($html) {
        $parts = explode('<', $html, 2);
        $part = $parts[0];

        $tag_parts = explode('>', $part);
        $tag_content = $tag_parts[0];
        
        if(!empty($tag_content)) {
            $name = $this->findName($tag_content);
            $element = $this->toElement($tag_content, $parts[0], $name);
            $type = $this->toType($element);

            if($name == 'head') {
                $this->head = ($type == 'open') ? true : false;
            }
            
            $this->build[] = [
                'name' => $name,
                'content' => $element,
                'type' => $type
            ];

            $this->setSkip($name, $type);

            if(!empty($tag_content)) {
                $content = (isset($tag_parts[1])) ? $tag_parts[1] : '';
                if(!empty($content)) {
                    $this->build[] = [
                        'content' => $this->compact($content, $name, $element),
                        'type' => 'content'
                    ];
                }
            }
        }

        $rest = (isset($parts[1])) ? $parts[1] : '';

        if(!empty($rest)) {
            $this->walk($rest);
        }
    }

    // Remove comments
    function removeComments($content = '') {
        return preg_replace('/<!--(.|\s)*?-->/', '', $content);
    }

    // Check if string contains string
    function contains($needle, $haystack) {
        return strpos($haystack, $needle) !== false;
    }

    // Return type of element
    function toType($element) {
        $type = (substr($element, 1, 1) == '/') ? 'close' : 'open';
        return $type;
    }

    // Create element
    function toElement($element, $noll, $name) {
        $element = $this->stripWhitespace($element);
        $element = $this->addChevrons($element, $noll);
        $element = $this->removeSelfSlash($element);
        $element = $this->removeMeta($element, $name);
        return $element;
    }

    // Remove unneeded element meta
    function removeMeta($element, $name) {
        if($name == 'style') {
            $element = str_replace([
                ' type="text/css"',
                "' type='text/css'"
            ],
            ['', ''], $element);
        } elseif($name == 'script') {
            $element = str_replace([
                ' type="text/javascript"',
                " type='text/javascript'"
            ],
            ['', ''], $element);
        }
        return $element;
    }

    // Strip whitespace from element
    function stripWhitespace($element) {
        if($this->skip == 0) {
            $element = preg_replace('/\s+/', ' ', $element);
        }
        return $element;
    }

    // Add chevrons around element
    function addChevrons($element, $noll) {
        $char = ($this->contains('>', $noll)) ? '>' : '';
        $element = '<' . $element . $char;
        return $element;
    }

    // Remove unneeded self slash
    function removeSelfSlash($element) {
        if(substr($element, -3) == ' />') {
            $element = substr($element, 0, -3) . '>';
        }
        return $element;
    }

    // Compact content
    function compact($content, $name, $element) {
        if($this->skip != 0) {
            $name = $this->skipName;
        } else {
            $content = preg_replace('/\s+/', ' ', $content);
        }

        if(
            $this->isSchema($name, $element) &&
            !empty($this->options['collapse_json_ld'])
            ) {
            return json_encode(json_decode($content));
        } if(in_array($name, $this->elements['skip'])) {
            return $content;
        } elseif(
            in_array($name, $this->elements['hard']) ||
            !empty($this->options['collapse_whitespace']) ||
            $this->head
            ) {
            return $this->minifyHard($content);
        } else {
            return $this->minifyKeepSpaces($content);
        }
    }

    function isSchema($name, $element) {
        if($name != 'script') return false;

        $element = strtolower($element);
        if($this->contains('application/ld+json', $element)) return true;
        return false;
    }

    // Build html
    function buildHtml() {
        $out = '';
        foreach($this->build as $build) {
            $out .= $build['content'];
        }
        return $out;
    }

    // Find name by part
    function findName($part) {
        $name_cut = explode(" ", $part, 2)[0];
        $name_cut = explode(">", $name_cut, 2)[0];
        $name_cut = explode("\n", $name_cut, 2)[0];
        $name_cut = preg_replace('/\s+/', '', $name_cut);
        $name_cut = strtolower(str_replace('/', '', $name_cut));
        return $name_cut;
    }

    // Set skip if elements are blocked from minification
    function setSkip($name, $type) {
        foreach($this->elements['skip'] as $element) {
            if($element == $name && $this->skip == 0) {
                $this->skipName = $name;
            }
        }
        if(in_array($name, $this->elements['skip'])) {
            if($type == 'open') {
                $this->skip++;
            }
            if($type == 'close') {
                $this->skip--;
            }
        }
    }

    // Minify all, even spaces between elements
    function minifyHard($element) {
        $element = preg_replace('!\s+!', ' ', $element);
        $element = trim($element);
        return trim($element);
    }

    // Strip but keep one space
    function minifyKeepSpaces($element) {
        return preg_replace('!\s+!', ' ', $element);
    }
}

class TinyMinify {
    static function html($html, $options = []) {
        $minifier = new TinyHtmlMinifier($options);
        return $minifier->minify($html);
    }
}