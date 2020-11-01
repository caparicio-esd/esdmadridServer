const path = require('path');
const fs = require('fs');
const Excel = require('exceljs');
const v = require('voca');

const Company = require('../lib/Company');


const extractAndSaveData = async () => {
    /**
     * Load data
     */
    const rawFile = 'lista.xlsx';
    const rawPath = path.resolve(__dirname, "") + "/../data/raw/" + rawFile;
    const workbook = new Excel.Workbook();

    const file = await workbook.xlsx.readFile(rawPath);
    const sheet = file.getWorksheet('convenios');
    let companies = [];


    /**
     * Load rows
     */
    sheet.getRows(6, sheet.lastRow.number - 6).forEach((row, i) => {
        const company = new Company(row._cells, i).exposeData();
        companies.push(company);
    });

    companies = companies
        .filter(comp => comp.id && comp.especialidad.length)
        .sort((a, b) => a.index - b.index);


    return companies;
};



module.exports = {
    extractAndSaveData
};
