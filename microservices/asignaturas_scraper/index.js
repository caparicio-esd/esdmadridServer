const fs = require('fs');
const chalk = require('chalk');
const getData = require('./utils/create_data');

/**
 *
 */
const writeDataInJSON = async () => {
    const asignaturas = await getData();
    console.log(chalk.green.bold('Parsing Asignaturas, finished!'));
};

writeDataInJSON();
