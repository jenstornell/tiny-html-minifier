# Tiny Html Minifier

![Version 1.0](https://img.shields.io/badge/version-1.0-blue.svg) ![MIT license](https://img.shields.io/badge/license-MIT-green.svg) [![Donate](https://img.shields.io/badge/give-donation-yellow.svg)](https://www.paypal.me/DevoneraAB)

## In short

- A PHP html minifier.
- It's really really fast.
- Only 1 file is required.
- This minifier uses a "back to basic" approach with almost no regular expressions.
- Inline `style` and `script` are minified with caution.
- Elements like `textarea`, `code` and `pre` will not be minified.
- Html comments and cdata will be removed.
- No options needed.

## Install & usage

### 1. Download the file

Download `tiny-html-minifier.php` or the whole ZIP.

### 2. Add the code

```php
<?php
require 'tiny-html-minifier.php';
echo TinyMinify::html($html);
```

## Before / after

### Before

```html
<!doctype html>
<html lang="en">
<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0" />

<link href="http://example.com/style.css" rel="stylesheet" />
<link rel="icon" href="http://example.com/favicon.png" />

<title>Tiny Html Minifier</title>

</head>
<body class="body">

<div class="main-wrap">
    <main>
        <textarea>
            Some text
            with newlines
            and some spaces
        </textarea>

        <div class="test">
            <p>This text</p>
            <p>should not</p>
            <p>wrap on multiple lines</p>
        </div>
    </main>
</div>
<script>
    console.log('Newlines should be kept.');
    console.log('Whitespace before and after each line should be gone.');
</script></body>
</html>
```

### After

```html
<!doctype html><html lang="en"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width,initial-scale=1.0" /><link href="http://example.com/style.css" rel="stylesheet" /><link rel="icon" href="http://example.com/favicon.png" /><title>Tiny Html Minifier</title></head><body class="body"><div class="main-wrap"> <main> <textarea>
            Some text
            with newlines
            and some spaces
        </textarea> <div class="test"> <p>This text</p> <p>should not</p> <p>wrap on multiple lines</p> </div> </main> </div> <script>
console.log('Newlines should be kept.');
console.log('Whitespace before and after each line should be gone.');
</script></body></html>
```

## Details

Instead of advanced regular expressions or a node solution, this minifier uses a "back to basic" approach. It's using explode to split the html elements into chunks. Different types of elements require different types of solutions.

### Head elements

The "head elements" are `!doctype body head html meta title link`. The special thing about them is that no single space is needed between the tags. That's because there should never be any inline elements in the head.

### Special elements

Special elements like `textarea`, `code` and `pre` needs to keep tabs, spaces and newlines intact. These elements will therefor not be minified at all.

### Comments and cdata

All html comments `<!-- -->` and cdata `<![CDATA[]]>` will be removed.

### Inline css

In the `style` elements, all double spaces, tabs and linebreaks will be removed.

### Inline javascript

In the `script` elements, the spaces at the start and end of each line will be removed. The newlines will be kept.

### All other elements

In the rest of the elements, single spaces will be kept to preserve inline elements and texts. Double spaces, tabs and newlines will be removed.

## Pitfalls

If you put html tags inside a script tag, it may not be minified correctly. That's because the minifier is not aware of where elements starts and ends. To get around it, move that kind of javascript code into an external javascript file.

## Requirements

- PHP7+

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/jenstornell/tiny-html-minifier/issues/new).

## License

[MIT](https://github.com/jenstornell/tiny-html-minifier/blob/master/license)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.

## Donate

If you want to make a donation, you can do that by sending any amount https://www.paypal.me/DevoneraAB

## Credits

- [Jens Törnell](https://github.com/jenstornell)