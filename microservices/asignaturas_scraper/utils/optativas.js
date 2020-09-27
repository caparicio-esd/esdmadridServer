/**
 * Scraping optativas
 * Para pillar profes, ects, cursos
 */

const axios = require('axios');
const cheerio = require('cheerio');
const he = require('he');
const chalk = require('chalk');

const optativasURL = 'https://www.esdmadrid.es/JefaturadeEstudios/Optativas_20_21/index2.htm';


/**
 * 
 */
String.prototype.extractCursos = function () {
    let arr = this.split(' ').filter(a => a != 'y').map(a => a[0]);
    arr = arr.map(a => {
        if (!isNaN(+a)) {
            return +a
        }
    });

    return arr;
};


/**
 * 
 */
const decodeTitle = (str) => {
    if (str) {
        return he.unescape(str).trim()
    } else {
        return '';
    }
};


/**
 * 
 */
const getOptativas = async () => {
    
    const data = [];

    console.log(chalk.green('Scraping optativas...'));
    const htmlDataOptativas = await axios.get(optativasURL).then(d => d.data);
    const $ = cheerio.load(htmlDataOptativas);
    const rows = $('tr:nth-child(n+2)');

    rows.each((i, elem) => {
        const dataItem = {
            courseRaw: $(elem).find('td').eq(0).text().trim().split(' / ')[0],
            ects: +$(elem).find('td').eq(4).html(),
            cursos: decodeTitle($(elem).find('td').eq(5).html()).extractCursos()
        };

        if (dataItem.courseRaw)
            data.push(dataItem);
    });

    return data;
};


/**
 * 
 */
module.exports = {
    getOptativas
};
