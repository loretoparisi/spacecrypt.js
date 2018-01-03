<?php

/**
 * Adapted from https://pug.sh/spacecrypt/ by https://twitter.com/nwbld
 * @author Loreto Parisi (loretoparisi at gmail dot com)
 */

function str2bin($text){
    $bin = array();
    for($i=0; strlen($text)>$i; $i++)
        $bin[] = decbin(ord($text[$i]));
    return implode(' ',$bin);
}
function bin2str($bin){
    $text = array();
    $bin = explode(' ', $bin);
    for($i=0; count($bin)>$i; $i++)
        $text[] = chr(bindec($bin[$i]));
    return implode($text);
}
function bin2hiddenHTML($str) {
    $str = str_replace(' ', '&#8288;', $str); // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
    $str = str_replace('0', '&#8203;', $str); // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
    $str = str_replace('1', '&#8204;', $str); // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
    return $str;
}
function hidden2binHTML($str) {
    // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
    $str = str_replace('&#8288;', ' ', $str);
    // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
    $str = str_replace('&#8203;', '0', $str);
    // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
    $str = str_replace('&#8204;', '1', $str);
    return $str;
}
function bin2hidden($str) {
    $str = str_replace(' ', "\xE2\x81\xA0", $str); // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
    $str = str_replace('0', "\xE2\x80\x8B", $str); // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
    $str = str_replace('1', "\xE2\x80\x8C", $str); // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
    return $str;
}
function hidden2bin($str) {
    // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
    $str = str_replace("\xE2\x81\xA0", ' ', $str);
    // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
    $str = str_replace("\xE2\x80\x8B", '0', $str);
    // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
    $str = str_replace("\xE2\x80\x8C", '1', $str);
    return $str;
}

// convert unicode to html hex string
function unicode2htmlhex($input) {
    $output = preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) {
        list($utf8) = $match;
        $binary = iconv('UTF-8', 'UTF-32BE', $utf8);
        $entity = vsprintf('&#x%X;', unpack('N', $binary));
        return $entity;
    }, $input);
    return $output;
}

$public = "Hello World";
$private = "What a fuck";

$binary = str2bin($private);
$hidden = bin2hidden($binary);

$encoded = $hidden.' '.$public;

echo 'Public:'.$public;
echo "\r\n";
echo 'Binary:'.$binary;
echo "\r\n";
echo 'Encoded binary:'.$hidden;
echo "\r\n";
echo 'Decoded binary:'. hidden2bin($encoded);
echo "\r\n";
echo 'Private:'. bin2str(hidden2bin($encoded));
echo "\r\n";

?>
