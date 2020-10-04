const fs = require('fs');
const path = require('path');
const pdf = require('pdf-parse');
const natural = require('natural');
const normalize = require('normalize-text');

const file = path.resolve(__dirname, 'data/raw') + '/sylabus.pdf';
let dataBuffer = fs.readFileSync(file);

pdf(dataBuffer).then(function (data) {
    const a = normalize.normalizeWhiteSpaces(data.text);
    console.log(a);

    const file = path.resolve(__dirname, 'data/clean') + '/plat.txt';
    fs.writeFile(file, a, (err, data) => {});
});
