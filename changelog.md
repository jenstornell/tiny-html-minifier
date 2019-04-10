# Changelog

## 2.2
- Added option to preserve conditional comments `<!--[if lt IE 10]>IE only<![endif]-->`.

## 2.1

- Added experimental feature support for minify `<script type="json-ld"></script>`.

## 2.0

- A complete rewrite and bump to version 2.
- Inline SVG files are supported and will be minified.
- Custom Elements support (`<my-element>My content</my-element>`).
- The slash of self closing tags are removed from ` />` to `>`.
- Unneeded element data are removed from `style` and `script` tags (` type="text/css"` and ` type="text/javascript"`).
- The minifier is now aware of what's inside `<head></head>` and will minify it without leaving the spaces (except for `style` and `script`).
- Instead of whitelist all allowed elements, it minifies all tags, but skip `textarea`, `code`, `pre` and `script`.
- The code length is reduced from around 300 lines to around 200 lines.

## 1.2

- Instead of remove CDATA, it will now be kept.
- Better JSON support.

## 1.1

Minor bug fixes

## 1.0

Initial release