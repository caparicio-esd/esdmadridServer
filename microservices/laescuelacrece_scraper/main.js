const fs = require('fs');

const data = require('./partials/gente');
const sdata = require('./partials/s_participants');
const infodata = require('./partials/infography');
const content_data = require('./partials/content');
const goals = require('./partials/goals');

const string_func = require('./utils/string_functions')();




/** 
 * Participants
 */
const participants = [];


/**
 * Parsing alumnos
 */
data.lol.participants.alumnos.content.forEach(al => {
    participants.push({
        name: al.capitalize01(),
        role: 'Alumnos',
        from: 'ESDMadrid'
    })
});


/**
 * Parsing profes
 */
data.lol.participants.profesores.content.forEach(al => {
    participants.push({
        name: al.capitalize01(),
        role: 'Profesores',
        from: 'ESDMadrid'
    })
});

/**
 * No docente
 */
data.lol.participants.personalNoDocente.content.forEach(al => {
    participants.push({
        name: al.capitalize01(),
        role: 'Personal No Docente',
        from: 'ESDMadrid'
    })
});

/**
 * No docente
 */
data.lol.participants.deFuera.recetasUrbanas.content.forEach(al => {
    participants.push({
        name: al.capitalize01(),
        role: 'Recetas Urbanas',
        from: 'De Fuera'
    })
});

/**
 * No docente
 */
data.lol.participants.deFuera.alumnosProfesoresColectivos.content.forEach(al => {
    participants.push({
        name: al.capitalize02().name,
        role: 'Alumnos, profesores y colectivos…',
        from: 'De Fuera',
        pais: al.capitalize02().pais,
    })
});







/**
 * Export obj
 */
const objOut = {
    content_data: content_data.contentBlocks,
    participants: participants,
    selected_participants: sdata.selected_participants,
    goals: goals.goalBlocks,
    infography: infodata.infography
};


fs.writeFile("./output/output.json", JSON.stringify(objOut), 'utf8', err => {
    if (err) {
        console.log("An error occured while writing JSON Object to File.");
        return console.log(err);
    }

    console.log("JSON file has been saved.");
});


console.log('Exiting out. Code 0');
