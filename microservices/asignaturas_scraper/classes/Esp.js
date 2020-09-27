class Esp {
    constructor(options) {
        this.type = options.type;
        this.name = options.name
        this.courses = options.courses || 4;
        this.ectsByCourse = options.ectsByCourse || 60;
        this.ectsTotal = this.courses * this.ectsByCourse;
        this.ectsDistribution = {
            'FB': 0,
            'OE': 0,
            'OPT': 0,
            'Prácticas externas': 0,
            'Trabajo Fin de grado': 0,
            'Trabajo Fin de master': 0,
            'Libre Configuración': 0,
        };
        this.asignaturas = [];
    }
}

const grafico = new Esp({
    type: 'grafico', 
    name: 'Diseño Gráfico',
    courses: 4,
});

const interiores = new Esp({
    type: 'interiores', 
    name: 'Diseño de Interiores',
    courses: 4,
});

const moda = new Esp({
    type: 'moda', 
    name: 'Diseño de Moda',
    courses: 4,
});

const producto = new Esp({
    type: 'producto', 
    name: 'Diseño de Producto',
    courses: 4,
});

const mdi = new Esp({
    type: 'Mi', 
    name: 'Master en Diseño Interactivo',
    courses: 1,
});

const mec = new Esp({
    type: 'Me', 
    name: 'Master en Retail y Espacios comerciales',
    courses: 1,
});


module.exports = {
    grafico,
    interiores,
    moda,
    producto,
    mdi,
    mec
};
