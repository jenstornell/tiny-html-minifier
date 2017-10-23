# Tiny Html Minifier

![Version 1.0](https://img.shields.io/badge/version-1.0-blue.svg) ![MIT license](https://img.shields.io/badge/license-MIT-green.svg) [![Donate](https://img.shields.io/badge/give-donation-yellow.svg)](https://www.paypal.me/DevoneraAB)

## In short

- A PHP html minifier.
- Really really fast.
- Only 1 single file is required.
- This minifier uses a "back to basic" approach with almost no regular expressions.
- Inline `style` and `script` are minified very carefully.
- Elements like `textarea`, `code` and `pre` will not be minified, because they should not be.
- Comments and cdata will be removed
- No options needed.

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

## Install

### 1. Download the file

Download `tiny-html-minifier.php` or the whole ZIP.

### 2. Add the code

```
require 'tiny-html-minifier.php';
echo TinyMinify::html($html);
```

## Minification details

Instead of advanced regular expressions or a node solution, this minifier uses a "back to basic" approach. It explode the html elements into chunks. Different types of elements require different types of solutions.

### Head elements

No single spaces are kept in the head because there should not be any text there.

### Normal elements

Single spaces are kept to preserve inline elements and texts.

### Special elements like `textarea`, `code` and `pre`

These elements need to keep tabs, spaces and newlines intact. These elements will therefor not be minified at all.

### Comments `<!-- -->` and cdata `<![CDATA[]]>`

All html comments and cdata will be removed.

### Css `style`

Comments, double spaces, tabs and linebreaks are removed.

### Javascript `script`

It will keep the newlines, but it will trim the spaces at the start and end of each line.

## Pitfalls

If you put html tags inside a script tag, it may not be minified correctly, because it's not aware of how things are nested.

## Requirements

- PHP7+

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/jenstornell/tiny-html-minifier/issues/new).

## License

[MIT](license.md)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.

## Donate

If you want to make a donation, you can do that by sending any amount https://www.paypal.me/DevoneraAB

## Credits

- [Jens Törnell](https://github.com/jenstornell)