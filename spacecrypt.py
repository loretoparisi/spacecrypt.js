#!/usr/bin/python -tt
# -*- coding: utf-8 -*-

# Adapted from https://pug.sh/spacecrypt/ by Adam Newbold https://twitter.com/nwbld
# @author M. Stella Tavella (mstella.tavella at gmail dot com)


def str2bin(s):
    return ' '.join(format(ord(i),'b').zfill(8) for i in s) #2

def hasNumbers(inputString):
    return any(char.isdigit() for char in inputString)

def text_from_bits(bits, encoding='utf-8', errors='surrogatepass'):
    n = int(bits, 2)
    return n.to_bytes((n.bit_length() + 7) // 8, 'big').decode(encoding, errors) or '\0'

def bin2str(s):
    # Removes the spaces from the binary string
    s = s.replace(" ", "")

    # Pretty (correct) print binary (add a space every 8 characters)
    s = ' '.join([s[i:i+8] for i in range(0, len(s), 8)]) 

    newBinary = s.split(" ")

    newBinary = [i for i in newBinary if hasNumbers(i)]
    newBinary = ''.join(newBinary)

    binaryCode = text_from_bits(newBinary)

    return ''.join(binaryCode)

def bin2hiddenHTML(s):
    s = s.replace(' ', '&#8288;') # Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
    s = s.replace('0', '&#8203;') # Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
    s = s.replace('1', '&#8204;') # Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
    return s

def hidden2binHTML(s):
    s = s.replace('&#8288;', ' ')
    s = s.replace('&#8203;', '0')
    s = s.replace('&#8204;', '1')
    return s

def bin2hidden(s):
    s = s.replace(' ', "\xE2\x81\xA0") # Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
    s = s.replace('0', "\xE2\x80\x8B") # Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
    s = s.replace('1', "\xE2\x80\x8C") # Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
    return s

def hidden2bin(s):
    s = s.replace("\xE2\x81\xA0", ' ')
    s = s.replace("\xE2\x80\x8B", '0')
    s = s.replace("\xE2\x80\x8C", '1')
    return s


if __name__ == "__main__":

    # TEST
    public = 'Hello World'
    private = 'What a fuck'

    # private text
    binary = str2bin(private)

    # hidden text
    hidden = bin2hidden(binary)

    encoded = hidden + ' ' + public

    decoded = bin2str(hidden2bin(encoded))

    print("Public:", public)
    print("Binary:", binary)
    print("Encoded binary:", hidden)
    print("Decoded binary:", hidden2bin(encoded))
    print("Private:", decoded)
