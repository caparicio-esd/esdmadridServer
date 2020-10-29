const fs = require('fs');
const chalk = require('chalk');
const getData = require('./utils/create_data');

/**
 *
 */
const writeDataInJSON = async () => {
    const profesores = await getData();

    fs.writeFile('./data/clean/profesores.json', JSON.stringify(profesores), 'utf8', (err) => {
        if (err) {
            console.log('An error occured while writing JSON Object to File.');
            return console.log(err);
        }
    
        console.log('JSON file has been saved.');
    });
    console.log(chalk.green.bold('Parsing profesores, finished!'));
};

writeDataInJSON();


