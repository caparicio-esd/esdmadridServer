/**
 * Create all asignaturas list
 */

const path = require('path');
const fs = require('fs');

const chalk = require('chalk');
const xlsx = require('xlsx');
const natural = require('natural');

const { Profesor } = require('../classes/Profesor');


/**
 * Load data
 */
const dataRawPath = path.resolve(__dirname, '../data/raw');

/**
 * Just Profesors List
 */
const fileName = `${dataRawPath}/Profesorado.xls`;
const workBook = xlsx.readFile(fileName, { type: 'array' });
const workSheet = workBook.Sheets['Profesores'];
const rawData = xlsx.utils.sheet_to_json(workSheet);

/**
 * Profesors + subjects list
 */
const fileName2 = `${dataRawPath}/profes.xlsx`;
const workBook2 = xlsx.readFile(fileName2, { type: 'array' });
const workSheet2 = workBook2.Sheets['TODO'];
const rawData2 = xlsx.utils.sheet_to_json(workSheet2);




/**
 * Set globals
 */
const profesores = [];

let idx = 0;
let isFinal = false;



/**
 * Create instances
 */
const createInstances = () => {
    rawData.forEach((rd) => {
        const cachedProfesor = new Profesor(rd);
    
        cachedProfesor.setIdx(idx);
        profesores.push(cachedProfesor);
        idx++;
    });
};


const cols2 = [
    '__rowNum__',
    'PROFESOR/A',
    'CORREO',
    'ESP. DOCENTE', //dep. code
    'DEPARTAMENTO',
    'CÓDIGO ASIGNATURA',
    'ASIGNATURA',
    'GRUPO',
    'TURNO',
    'ESPECIALIDAD',
    'CARÁCTER',
    'SEMESTRE',
];

/**
 * Set extra data
 */
const setExtraData = () => {
    rawData2.forEach((rd) => {        
        const profesor = profesores.find((prof) => (prof.surname1 + ' ' + prof.surname2 +', '+ prof.name) == rd['PROFESOR/A'].trim())                 

        if(profesor){
            profesor.addExtraData(rd[cols2[2]], rd[cols2[4]],rd[cols2[3]],rd[cols2[9]]);
        }
    });
};



/**
 *
 */
const getData = async () => {
    console.log(chalk.green('Parsing Profesores...'));
    createInstances();
    setExtraData();

    return profesores;
};

module.exports = getData;
