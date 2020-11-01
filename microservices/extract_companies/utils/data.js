const xlsx = require('xlsx');
const path = require('path');
const fs = require('fs');
const v = require('voca');
const Company = require('../lib/Company');


let fieldsRelations = [];
let data = [];


const extractAndSaveData = () => {
    /**
     * Load data
     */
    const rawFile = 'lista.xlsx';
    const rawPath = path.resolve(__dirname, "") + "/../data/raw/" + rawFile;
    const fileRaw = xlsx.readFile(rawPath, { type: 'array' });
    const dataRaw = fileRaw.Sheets['convenios'];

    data = xlsx.utils.sheet_to_json(dataRaw, { raw: true });


    /**
     * Load fields
     */
    const fields = Object.entries(data[2]).map(d => d[1].split('\r\n').join(' ').toLowerCase());
    fieldsRelations = Object.entries(data[2]).map((d, i) => ({ id: d[0], fieldRaw: fields[i] }))
    fieldsRelations = fieldsRelations.map(f => ({ ...f, field: v.latinise(v.camelCase(f.fieldRaw)) }))


    /**
     * Set data objs
     */
    const companies = data
        .map(dItem => new Company(dItem, fieldsRelations))
        .filter(dItem => dItem.id && dItem.especialidad)
        .map(dItem => dItem.exposeProps())
        .sort((a, b) => a.id - b.id);


    /**
     * writeJSON
     */
    fs.writeFile(
        path.resolve(__dirname, "../") + "/data/clean/" + "companies.json",
        JSON.stringify(companies, null, 4),
        () => { }
    );
};



module.exports = {
    fieldsRelations,
    data,
    extractAndSaveData
};
