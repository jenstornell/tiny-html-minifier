# Tiny Html Minifier

![Version 2.2](https://img.shields.io/badge/version-2.2-blue.svg) ![MIT license](https://img.shields.io/badge/license-MIT-green.svg) [![Donate](https://img.shields.io/badge/give-donation-yellow.svg)](https://www.paypal.me/DevoneraAB)

[Changelog](changelog.md)

## In short

- A HTML minifier in PHP.
- It's really really fast.
- Only 1 file is required.
- Almost no regular expressions.
- Almost no options.

## Details - What the minifier does

- Remove HTML comments.
- Remove slash in self closing elements. ` />` becomes `>`.
- Remove ` type="text/css"` and `type="text/javascript"` in `style` and `script` tags.
- Minimize elements within `<head></head>`. It will not keep any whitespace (except inside `script`).
- Minimize elements within `<body></body>` but keep spaces between tags to preserve inline data (optional).
- Minimize inline SVG files (which are a bunch of XML tags).
- Minimize Custom Elements. They look like this: `<my-element>My content</my-element>`.
- Skip `code`, `pre`, `script` and `textarea` from being minified.

## Install & usage

### 1. Download

**ZIP**

Download `tiny-html-minifier.php` or the whole ZIP.

**Composer**

You can install it with Composer as well.

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
    console.log('Script tags are not minified');
    console.log('This is inside a script tag');
</script></body>
</html>
```

### After

```html
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><link href="http://example.com/style.css" rel="stylesheet"><link rel="icon" href="http://example.com/favicon.png"><title>Tiny Html Minifier</title></head> <body class="body"><div class="main-wrap"> <main> <textarea>
            Some text
            with newlines
            and some spaces
        </textarea> <div class="test"> <p>This text</p> <p>should not</p> <p>wrap on multiple lines</p> </div> </main> </div> <script>
    console.log('Script tags are not minified');
    console.log('This is inside a script tag');
</script></body></html>
```

## Options

```php
<?php
require 'tiny-html-minifier.php';
echo TinyMinify::html($html, $options = [
    'collapse_whitespace' => false,
    'disable_comments' => false,
]);
```

### collapse_whitespace

#### Not collapsed

Spaces are preserved (except for most elements within `<head></head>`). It's good when using the elements inline. This is the default.

```html
<ul><li> <a href="#"> My link </a></li><li> <a href="#"> My link </a></li> </ul>
```

#### Collapsed

Spaces are collapsed. The text inside the element is still untouched. Set this value to `true` and you will save a few extra bytes.

```html
<ul><li><a href="#">My link</a></li><li><a href="#">My link</a></li></ul>
```

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