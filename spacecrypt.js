/**
 * Adapted from https://pug.sh/spacecrypt/ by Adam Newbold https://twitter.com/nwbld
 * @author Loreto Parisi (loretoparisi at gmail dot com)
 */

function str2bin(str, spaceSeparatedOctets) {
    function zeroPad(num) {
        return "00000000".slice(String(num).length) + num;
    }

    return str.replace(/[\s\S]/g, function (str) {
        str = zeroPad(str.charCodeAt().toString(2));
        return !1 == spaceSeparatedOctets ? str : str + " "
    });
};


function bin2str(str) {
    // Removes the spaces from the binary string
    str = str.replace(/\s+/g, '');
    // Pretty (correct) print binary (add a space every 8 characters)
    str = str.match(/.{1,8}/g).join(" ");

    var newBinary = str.split(" ");
    var binaryCode = [];

    for (i = 0; i < newBinary.length; i++) {
        binaryCode.push(String.fromCharCode(parseInt(newBinary[i], 2)));
    }

    return binaryCode.join("");
}

function bin2hiddenHTML(str) {
    str = str.replace(' ', '&#8288;'); // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
    str = str.replace('0', '&#8203;'); // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
    sstr = str.replace('1', '&#8204;'); // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
    return str;
}

function hidden2binHTML(str) {
    str = str.replace('&#8288;', ' ');
    str = str.replace('&#8203;', '0');
    str = str.replace('&#8204;', '1');
    return str;
}

function bin2hidden(str) {
    str = str.replace(' ', "\xE2\x81\xA0"); // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
    str = str.replace('0', "\xE2\x80\x8B"); // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
    sstr = str.replace('1', "\xE2\x80\x8C"); // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
    return str;
}

function hidden2bin(str) {
    str = str.replace("\xE2\x81\xA0", ' ');
    str = str.replace("\xE2\x80\x8B", '0');
    str = str.replace("\xE2\x80\x8C", '1');
    return str;
}

// TEST
var public = 'Hello World';
var private = 'What a fuck';
// private text
var binary = str2bin(private);
// hidden text
var hidden = bin2hidden(binary);

var encoded = hidden+' '+public;
var decoded = bin2str(hidden2bin(encoded));

console.log("Public:",public);
console.log("Binary:",binary);
console.log("Encoded binary:",hidden);
console.log("Decoded binary:",hidden2bin(encoded));
console.log("Private:",decoded);