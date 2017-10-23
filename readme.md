# Tiny Html Minifier

![Version 1](https://img.shields.io/badge/version-1-blue.svg) ![MIT license](https://img.shields.io/badge/license-MIT-green.svg) [![Donate](https://img.shields.io/badge/give-donation-yellow.svg)](https://www.paypal.me/DevoneraAB)

- Only 1 single file is required.
- This minifier uses a "back to basic" approach with less regular expressions.
- Inline css and javascript are minified very carefully.

## Install

### 1. Download the file

Download `tiny-html-minifier.php` or the whole ZIP.

### 2. Add the code

```
require_once __DIR__ '\tiny-html-minifier.php';
echo TinyMinify::html($html);
```

## Minification details

Instead of advanced regular expressions or a node solution, this minifier uses a "back to basic" approach. It explode html tags into chunks and depending on what type is it, it will minify it in a certain way.

### Normal html

Single spaces are kept to preserve inline elements and texts.

### Head

No single spaces are kept in the head elements as it should not be any text there.

### Textarea, code and pre

These elements need to keep tabs, spaces and newlines intact so these elements will not be minified at all.

### Html comments and cdata

All html comments and cdata will be removed.

### Style

Comments, double spaces, tabs and linebreaks are removed.

### Script

It will keep the newlines, but it will trim the spaces at the start and end of each line.

## Requirements

- PHP7+

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/jenstornell/tiny-html-minifier/issues/new).

## License

[MIT](https://opensource.org/licenses/MIT)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.

## Donate

If you want to make a donation, you can do that by sending any amount https://www.paypal.me/DevoneraAB

## Credits

- [Jens Törnell](https://github.com/jenstornell)