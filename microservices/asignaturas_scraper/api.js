const fs = require('fs');
const argv = require('yargs').argv;

const asignaturas = JSON.parse(fs.readFileSync('./data/clean/asignaturas.json', 'utf8'));
const { getJustAsignaturas, getAsignaturas } = require('./utils/plan_estudios_api');

getAsignaturas((write = true));
