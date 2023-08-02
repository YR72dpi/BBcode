*chatGPT Documentation*

# BBCode to HTML Converter

**Class**: bbcode

## Description
The `bbcode` class is a PHP utility that allows you to convert BBCode (Bulletin Board Code) to HTML. It is inspired by the project [Genert/bbcode](https://github.com/Genert/bbcode) on GitHub.

## Parsers
The `bbcode` class provides various parsers for different BBCode tags. Each parser is defined as an associative array with the following elements:

- `pattern`: A regular expression to match the BBCode tag.
- `replace`: The HTML code to replace the matched BBCode tag.
- `content`: The content to be placed inside the HTML code.
- `exemple`: An optional example of the BBCode tag for the menu bar.

The available parsers include:

- **Gras**: `[b]Texte[/b]` -> `<b>Texte</b>`
- **Italic**: `[i]Texte[/i]` -> `<i>Texte</i>`
- **Sous ligné**: `[u]Texte[/u]` -> `<u>Texte</u>`
- **Petit**: `[small]Texte[/small]` -> `<small>Texte</small>`
- **Titre**: `[t]Titre[/t]` -> `<h4>Titre</h4>`
- **Paragraphe**: `[p]Texte[/p]` -> `<p>Texte</p>`
- **Citation**: `[q]Citation[/q]` -> `<blockquote>Citation</blockquote>`
- **Centrer**: `[center]Texte[/center]` -> `<div style="text-align:center">Texte</div>`
- **URL**: `[url]Url[/url]` -> `<a target="_blank" href="Url">Url</a>`
- **URL avec nom**: `[url=Url]Nom[/url]` -> `<a target="_blank" href="Url">Nom</a>`
- **Image**: `[img]Url de l'image[/img]` -> `<img src="Url de l'image">`
- **Liste**: 
  ```
  [list]
      [*] texte
      [*] texte
      [*] texte
  [/list]
  ```
  -> `<ul><li>texte</li><li>texte</li><li>texte</li></ul>`
- **Liste 123**:
  ```
  [list=1]
      [*] texte
      [*] texte
      [*] texte
  [/list]
  ```
  -> `<ol><li>texte</li><li>texte</li><li>texte</li></ol>`
- **Liste abc**:
  ```
  [list=a]
      [*] texte
      [*] texte
      [*] texte
  [/list]
  ```
  -> `<ol type="a"><li>texte</li><li>texte</li><li>texte</li></ol>`
- **Liste ABC**:
  ```
  [list=A]
      [*] texte
      [*] texte
      [*] texte
  [/list]
  ```
  -> `<ol type="A"><li>texte</li><li>texte</li><li>texte</li></ol>`
- **Liste item**: `[*] texte` -> `<li>texte</li>`

## Methods

### convertToHtml(string $source, bool $caseSensitive = null): string
Converts BBCode to HTML.

**Parameters**
- `$source`: The text containing BBCode to convert to HTML.
- `$caseSensitive` (optional): A boolean indicating whether the conversion should be case-sensitive. By default, the conversion is case-insensitive.

**Returns**
- Returns the resulting HTML text after the conversion.

### deleteBalise(string $source): string
Removes all BBCode tags from the text.

**Parameters**
- `$source`: The text containing BBCode tags to remove.

**Returns**
- Returns the text without BBCode tags.

### addParser(string $name, string $pattern, string $replace, string $content, string $exemple = null): bbcode
Adds a new parser for a custom BBCode tag.

**Parameters**
- `$name`: The name of the tag in the menu.
- `$pattern`: The regular expression (regex) to detect the BBCode tag.
- `$replace`: The HTML code to replace the BBCode tag.
- `$content`: The content to be placed in the resulting HTML code.
- `$exemple` (optional): The default value in the menu input. If not provided, the tag will not be displayed in the menu bar.

**Returns**
- Returns the instance of the `bbcode` class, allowing method chaining.

### addLinebreakParser(): bbcode
Adds a parser for the line break BBCode tag.

**Returns**
- Returns the instance of the `bbcode` class, allowing method chaining.

### menu(string $idClassForm, bool $js_css = true): string
Creates a menu bar with all available BBCode patterns.

**Parameters**
- `$idClassForm`: The ID of your form input where the BBCode will be inserted.
- `$js_css` (optional): A boolean indicating whether to include CSS styles and JavaScript scripts for the menu. By default, it is `true`.

**Returns**
- Returns the HTML code of the menu bar with buttons to insert BBCode tags.

## Example
```php
// Creating an instance of the bbcode class
$bbcode = new bbcode();

// Convert BBCode to HTML
$source = "[b]Bold Text[/b] [i]Italic Text[/i]";
$htmlResult = $bbcode->convertToHtml($source);

// Remove BBCode tags
$sourceWithBalises = "[b]Bold Text[/b] [i]Italic Text[/i]";
$textWithoutBalises = $bbcode->deleteBalise($sourceWithBalises);

// Add a custom parser
$bbcode->addParser("Color", "/\[color=([a-zA-Z]+)\](.*?)\[\/color\]/s", "<span style='color:$1;'>$2</span>", "$2", "[color=red]Red Text[/color]");

// Create a menu bar for inserting BBCode tags
$menu = $bbcode->menu("input_bbcode");
```

Please note that the above examples are based on the available methods in the `bbcode` class. You can use them to manipulate and handle BBCode in your PHP application.