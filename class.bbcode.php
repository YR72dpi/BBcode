<?php
require_once 'class.text.php';
/**
* inspirer par https://github.com/Genert/bbcode
*/
class bbcode { //extends AnotherClass

	/* ------------------------------------- *\
			private
	\* ------------------------------------- */

	/* --- Variable ---*/


	private $parsers = [
		'<b>Gras</b>' => [
            'pattern' => '/\[b\] *?(.*?) *?\[\/b\]/s',
            'replace' => '<b>$1</b>',
            'content' => '$1',
            'exemple' => '[b]Texte[/b]'
        ],
        '<i>Italic</i>' => [
            'pattern' => '/\[i\] *?(.*?) *?\[\/i\]/s',
            'replace' => '<i>$1</i>',
            'content' => '$1',
            'exemple' => '[i]Texte[/i]'
        ],
        '<u>Sous ligné</u>' => [
            'pattern' => '/\[u\] *?(.*?) *?\[\/u\]/s',
            'replace' => '<u>$1</u>',
            'content' => '$1',
            'exemple' => '[u]Texte[/u]'
        ],
        /*'Barré' => [
            'pattern' => '/\[s\] *?(.*?) *?\[\/s\]/s',
            'replace' => '<s>$1</s>',
            'content' => '$1',
            'exemple' => '[s]Texte[/s]'
        ],*/
        'Petit' => [
            'pattern' => '/\[small\] *?(.*?) *?\[\/small\]/s',
            'replace' => '<small>$1</small>',
            'content' => '$1',
            'exemple' => '[small]Texte[/small]'
        ],
         'Titre' => [
            'pattern' => '/\[t\] *?(.*?) *?\[\/t\]/s',
            'replace' => '<h4>$1</h4>',
            'content' => '$1',
            'exemple' => '[t]Titre[/t]'
        ],
        'Paragraphe' => [
            'pattern' => '/\[p\] *?(.*?) *?\[\/p\]/s',
            'replace' => '<p>$1</p>',
            'content' => '$1',
            'exemple' => "[p]\nTexte\n[/p]"
        ],
        'Citation' => [
            'pattern' => '/\[q\] *?(.*?) *?\[\/q\]/s',
            'replace' => '<blockquote>$1</blockquote>',
            'content' => '$1',
            'exemple' => "[q]\nCitation\n[/q]"
        ],
        'Centrer' => [
            'pattern' => '/\[center\] *?(.*?) *?\[\/center\]/s',
            'replace' => '<div style="text-align:center">$1</div>',
            'content' => '$1',
            'exemple' => '[center]Texte[/center]'
        ],
        'Url' => [
            'pattern' => '/\[url\] *?(.*?) *?\[\/url\]/s',
            'replace' => '<a target="_blank" href="$1">$1</a>',
            'content' => '$1',
            'exemple' => '[url]Url[/url]'
        ],
        'Url avec nom' => [
            'pattern' => '/\[url\= *?(.*?) *?\] *?(.*?) *?\[\/url\]/s',
            'replace' => '<a target="_blank" href="$1">$2</a>',
            'content' => '$2',
            'exemple' => ''
        ],
        'Image' => [
            'pattern' => '/\[img\] *?(.*?) *?\[\/img\]/s',
            'replace' => '<img src="$1">',
            'content' => '$1',
            'exemple' => '[img]Url de l\'image[/img]'
        ],
        'Liste' => [
            'pattern' => '/\[list\] *?(.*?) *?\[\/list\]/s',
            'replace' => '<ul>$1</ul>',
            'content' => '$1',
            'exemple' => "[list] \n\t[*] texte \n\t[*] texte \n\t[*] texte\n[/list]"
        ],
        'Liste 123' => [
            'pattern' => '/\[list=1\] *?(.*?) *?\[\/list\]/s',
            'replace' => '<ol>$1</ol>',
            'content' => '$1',
            'exemple' => "[list=1]\n \t[*] texte\n \t[*] texte\n \t[*] texte\n[/list]"
        ],
        'Liste abc' => [
            'pattern' => '/\[list=a\] *?(.*?) *?\[\/list\]/s',
            'replace' => '<ol type="a">$1</ol>',
            'content' => '$1',
            'exemple' => "[list=a]\n \t[*] texte\n \t[*] texte\n \t[*] texte\n[/list]"
        ],
        'Liste ABC' => [
            'pattern' => '/\[list=A\] *?(.*?) *?\[\/list\]/s',
            'replace' => '<ol type="A">$1</ol>',
            'content' => '$1',
            'exemple' => "[list=a]\n \t[*] texte\n \t[*] texte\n \t[*] texte\n[/list]"
        ],
        'Liste item' => [
            'pattern' => '/\[\*\](.*)/',
            'replace' => '<li>$1</li>',
            'content' => '$1',
            'exemple' => "\t[*]"
        ],
        /*'Code' => [
            'pattern' => '/\[code\] *?(.*?) *?\[\/code\]/s',
            'replace' => '<code>$1</code>',
            'content' => '$1',
            'exemple' => '[code]Texte[/code]'
        ],
        'Indice' => [
            'pattern' => '/\[sub\] *?(.*?) *?\[\/sub\]/s',
            'replace' => '<sub>$1</sub>',
            'content' => '$1',
            'exemple' => '[sub]Texte[/sub]'
        ],
        'Exposant' => [
            'pattern' => '/\[sup\] *?(.*?) *?\[\/sup\]/s',
            'replace' => '<sup>$1</sup>',
            'content' => '$1',
            'exemple' => '[sup]Texte[/sup]'
        ],*/
	];

    private $RawBalise = [];

    /* --- function  --- */

	/* ------------------------------------- *\
			public
	\* ------------------------------------- */

	/* --- Variable ---*/

	/* --- function  --- */
	
	//public function __construct(argument){}

	public function convertToHtml($source = string, $caseSensitive = null){
        $caseInsensitiveBool = is_null($caseSensitive) ? true : $caseSensitive;
        foreach ($this->parsers as $name => $parser) {
            $pattern = ($caseInsensitiveBool) ? $parser['pattern'].'i' : $parser['pattern'];
            while (preg_match($pattern, $source)) {
                $source = preg_replace($pattern, $parser['replace'], $source);
            }
        }
        return $source;
    }

    public function deleteBalise($source = string){
            
        foreach ($this->parsers as $name => $parser) {
            $pattern = $parser['pattern'];
            $pattern = preg_replace('/\](.*?)\[/', "]|\[", $pattern);
            $this->RawBalise[] = $pattern;
        }
        $source = preg_replace($this->RawBalise, "", $source);
        return $source;
    }

    public function addParser($name = string, $pattern = string, $replace = string, $content = string, $exemple = null) {
        $condition = (!is_null($exemple) && !empty($exemple) && is_string($exemple)) ? true : false;
        $exemple = ($condition) ? $exemple : '';
        $this->parsers[$name] = [
            'pattern' => $pattern,
            'replace' => $replace,
            'content' => $content,
            'exemple' => $exemple
        ];
        return $this;
    }

    public function addLinebreakParser() {
        return $this->addParser("Retour à la ligne", "/(\/n)/i", "<br />", "", "/n \n");
    }

    public function menu($idClassForm = string, $js_css = true) {

        $menu = "";

        // == div html menu

        $menu .= '<div class="bbcode_balise_add_button">';
        foreach ($this->parsers as $name => $parser) {
            $exemple_verifier = (!empty($parser['exemple'])) ? $parser['exemple'] : false;
            if ($exemple_verifier) {
                $menu .= '<button class="new_balise" type="button" data="'.$parser['exemple'].'">'.$name.'</button>';
            }  
        }
        $menu .= "</div>";

        // == fin div
        
        if(is_bool($js_css) && $js_css == false) { $js_css = false; }
        if ($js_css) {
            
        $menu .= "
            <style type=\"text/css\">
                .bbcode_balise_add_button {
                    margin: 10 0 0 0;
                    padding-left: 3; 
                    width: auto;
                    border-radius: 10px;
                }
                .bbcode_balise_add_button button.new_balise {
                    background-color: white;
                    border: none;
                    margin: -1 0 0 -3;
                    padding: 5px 10px 5px 10px;
                    outline: none;
                    border: 1px solid buttonface;
                }
                .bbcode_balise_add_button button.new_balise:hover {
                    border-bottom: 1px solid black;
                }
            </style>
            <script type='text/javascript'>
        
                function insert_text (char) {
                    var input = $('".$idClassForm."');
                    var cursorPos = input.prop('selectionStart');
                    var text = input.val();
                    var attr = char;
                    var text_avant = text.substring(0, cursorPos);
                    var text_apres = text.substring(cursorPos, text.length);
                    input.val(text_avant + attr + text_apres);
                }

                $('.new_balise').click(function(){
                    insert_text( $(this).attr('data') );
                });

            </script>
            ";

        }
        return $menu;
    }
}
?>