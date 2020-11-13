const fs = require('fs');
const path = require('path');
const Excel = require('exceljs');
const Convenio = require('./lib/Convenio.js');

const writeData = true;

const extractAndSaveData = async () => {
    /**
     * Load data
     */
    const rawFile = 'convenios.xlsx';
    const rawPath = path.resolve(__dirname, "") + "/data/raw/" + rawFile;
    const workbook = new Excel.Workbook();

    const file = await workbook.xlsx.readFile(rawPath);
    const sheet = file.getWorksheet('convenios');
    let convenios = [];


    /**
     * Load rows
     */
    sheet.getRows(1, sheet.lastRow.number).forEach((row, i) => {
        const convenio = new Convenio(row._cells);
        convenios.push(convenio);
    });

    console.log(convenios);


    if (writeData) {
        fs.writeFileSync(
            path.resolve(__dirname, "") + "/data/clean/" + "convenios.json",
            JSON.stringify(convenios, null, 4),
            () => { }
        );
    }

    return convenios;
};


extractAndSaveData();