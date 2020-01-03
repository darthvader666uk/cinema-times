<?php

/*
 * Dumpr - Dump any resource with syntax highlighting, indenting and variable type information to the screen in a very intuitive format
 *
 * Licensed under the terms of the GNU Lesser General Public License:
 *      http://www.opensource.org/licenses/lgpl-license.php
 *
 * Author    Jari Berg Jensen &lt;jari@razormotion.com&gt;
 *           http://www.razormotion.com/software/dumpr/
 * License   LGPL
 * Modified  2005/05/05
 * Revision  1.8
 */

// dump any data with syntax highlighting, indenting and variable type information
// @param mixed $data
// @param bool $sort will sort data (defaults to false)
function dumpr($data, $sort = false) {
        if ($sort) {
                ksort($data);
        }
    ob_start();
    var_dump($data);
    $c = ob_get_contents();
    ob_end_clean();

        $c = preg_replace("/\r\n|\r/", "\n", $c);
    $c = str_replace("]=>\n", '] = ', $c);
    $c = preg_replace('/= {2,}/', '= ', $c);
    $c = preg_replace("/\[\"(.*?)\"\] = /i", "[$1] = ", $c);
    $c = preg_replace('/  /', "    ", $c);
    $c = preg_replace("/\"\"(.*?)\"/i", "\"$1\"", $c);

        $c = htmlspecialchars($c, ENT_NOQUOTES);

        // Expand numbers (ie. int(10) => int(2) 10, float(128.64) => float(6) 128.64 etc.)
        $c = preg_replace("/(int|float)\(([0-9\.]+)\)/ie", "'$1('.strlen('$2').') <span class=\"number\">$2</span>'", $c);

    // Syntax Highlighting of Strings. This seems cryptic, but it will also allow non-terminated strings to get parsed.
        $c = preg_replace("/(\[[\w ]+\] = string\([0-9]+\) )\"(.*?)/sim", "$1<span class=\"string\">\"", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\})/sim", "$1</span>$2", $c);
        $c = preg_replace("/(\"\n{1,})( {0,}\[)/sim", "$1</span>$2", $c);
        $c = preg_replace("/(string\([0-9]+\) )\"(.*?)\"\n/sim", "$1<span class=\"string\">\"$2\"</span>\n", $c);

        $regex = array(
                // Numberrs
                'numbers' => array('/(^|] = )(array|float|int|string|resource|object\(.*\)|\&amp;object\(.*\))\(([0-9\.]+)\)/i', '$1$2(<span class="number">$3</span>)'),
                // Keywords
                'null' => array('/(^|] = )(null)/i', '$1<span class="keyword">$2</span>'),
                'bool' => array('/(bool)\((true|false)\)/i', '$1(<span class="keyword">$2</span>)'),
                // Types
                'types' => array('/(of type )\((.*)\)/i', '$1(<span class="type">$2</span>)'),
                // Objects
                'object' => array('/(object|\&amp;object)\(([\w]+)\)/i', '$1(<span class="object">$2</span>)'),
                // Function
                'function' => array('/(^|] = )(array|string|int|float|bool|resource|object|\&amp;object)\(/i', '$1<span class="function">$2</span>('),
        );

        foreach ($regex as $x) {
                $c = preg_replace($x[0], $x[1], $c);
        }

    $style = '
    /* outside div - it will float and match the screen */
    .dumpr {
        margin: 2px;
        padding: 2px;
                background-color: #fbfbfb;
        float: left;
        clear: both;
    }
        /* font size and family */
        .dumpr pre {
        color: #000000;
        font-size: 9pt;
        font-family: "Courier New",Courier,Monaco,monospace;
        margin: 0px;
        padding-top: 5px;
                padding-bottom: 7px;
                padding-left: 9px;
                padding-right: 9px;
                text-align: left;
        }
    /* inside div */
    .dumpr div {
        background-color: #fcfcfc;
        border: 1px solid #d9d9d9;
        float: left;
        clear: both;
    }
    /* syntax highlighting */
    .dumpr span.string {color: #c40000;}
    .dumpr span.number {color: #ff0000;}
    .dumpr span.keyword {color: #007200;}
    .dumpr span.function {color: #0000c4;}
    .dumpr span.object {color: #ac00ac;}
    .dumpr span.type {color: #0072c4;}
    ';

    $style = preg_replace("/ {2,}/", "", $style);
    $style = preg_replace("/\t|\r\n|\r|\n/", "", $style);
    $style = preg_replace("/\/\*.*?\*\//i", '', $style);
    $style = str_replace('}', '} ', $style);
    $style = str_replace(' {', '{', $style);
    $style = trim($style);

        $c = trim($c);
        $c = preg_replace("/\n<\/span>/", "</span>\n", $c);

    echo "\n<!-- Dumpr Begin -->\n";
    echo "<style type=\"text/css\">".$style."</style>\n";
    echo "<div class=\"dumpr\"><div><pre>\n$c\n</pre></div></div><div style=\"clear:both;\">&nbsp;</div>";
    echo "\n<!-- Dumpr End -->\n";
}

// dump constants matching $mask or all constants if $mask is null
// @param string $mask[optional] mask to apply or dumpr everything if null
// @param bool $sort[optional] sort defaults to true
function dumprc($mask = null, $sort = true) {
        $arr = get_defined_constants();
        $vars = array();
        foreach ($arr as $key => $val) {
                if (!$mask || stristr($key, $mask)) {
                        $vars[$key] = $val;
                }
        }
        dumpr($vars, $sort);
}

// dump global variables matching $mask or all global variables if $mask is null
// @param string $mask[optional] mask to apply or dumpr everything if null
// @param bool $sort[optional] sort defaults to true
function dumprg($mask = null, $sort = true) {
        $arr = $GLOBALS;
        $vars = array();
        foreach ($arr as $key => $val) {
                if (!$mask || stristr($key, $mask)) {
                        $vars[$key] = $val;
                }
        }
        dumpr($vars, $sort);
}

// dump data matching $mask or complete array if $mask is null
// @param string $mask[optional] mask to apply or dumpr everything if null
// @param bool $sort[optional] sort defaults to true
function dumprx($arr, $mask = null, $sort = true) {
        $vars = array();
        foreach ($arr as $key => $val) {
                if (!$mask || stristr($key, $mask)) {
                        $vars[$key] = $val;
                }
        }
        dumpr($vars, $sort);
}


/*** end dumpr ****/
?>