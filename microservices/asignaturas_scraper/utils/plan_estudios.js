/**
 * Scraping plan de estudios de la escuela
 * Para pillar ects
 */

const axios = require('axios');
const cheerio = require('cheerio');
const fs = require('fs');
const chalk = require('chalk');


const planEstudiosURL = {
    grafico: 'https://esdmadrid.es/plan-de-estudios-diseno-grafico/',
    producto: 'https://esdmadrid.es/plan-de-estudios-diseno-de-producto/',
    interiores: 'https://esdmadrid.es/plan-de-estudios-diseno-de-interiores/',
    moda: 'https://esdmadrid.es/plan-de-estudios-diseno-de-moda/',
};


/**
 * 
 */
const getAsignaturas = async () => {

    const data = [];
    const htmlData = [];

    Object.entries(planEstudiosURL).forEach(async (estudio, i) => {
        console.log(chalk.green(`Scraping plan de estudios de ${estudio[0]}...`));
        htmlData[i] = axios.get(estudio[1]).then(d => d.data);
    });

    await Promise.all(htmlData.map(async htmlDataItem => {
        
        const html = await htmlDataItem;
        const $ = cheerio.load(html, { decodeEntities: true });
        const rows = $('table')

        rows.each((i, row) => {
            const basicas = $(row).find('td.basicas').not('.num-dcha');
            const especialidades = $(row).find('td.especialidad').not('.num-dcha');

            basicas.each((j, basica) => {
                const dataItem = {
                    title: $(basica).text(),
                    ects: +$(basica).next().text(),
                    type: 'FB'
                };
                if (dataItem.ects < 10)
                    data.push(dataItem);
            });

            especialidades.each((j, especialidad) => {
                const dataItem = {
                    title: $(especialidad).text(),
                    ects: +$(especialidad).next().text(),
                    type: 'OE'
                };
                if (dataItem.ects < 10)
                    data.push(dataItem);
            });
        });
    }));

    return data;
};


/**
 * 
 */
module.exports = {
    getAsignaturas
};
