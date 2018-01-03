# spacecrypt.js
 This hides messages within other messages by converting them into binary data, and then converting the binary data into zero-width characters.
 JavaScript port of [SpaceCrypt](https://pug.sh/spacecrypt/) by [Adam Newbold](https://twitter.com/nwbld)

 ## Usage
 To run in `node.js`
 ```
 node spacecrypt
 Public: Hello World
Binary: 01010111 01101000 01100001 01110100 00100000 01100001 00100000 01100110 01110101 01100011 01101011 
Encoded binary: â1010111â 01101000 01100001 01110100 00100000 01100001 00100000 01100110 01110101 01100011 01101011 
Decoded binary: 01010111 01101000 01100001 01110100 00100000 01100001 00100000 01100110 01110101 01100011 01101011  Hello World
Private: What a fuck
```
