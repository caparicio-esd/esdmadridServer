const cols = [
    'APELLIDO1',
    'APELLIDO2',
    'NOMBRE',
    'SEXO',
    'ESTADO',
    'CUERPO',
];



class Profesor {
    constructor(data, id = 0) {
        this.id = id;
        this.name = data[cols[2]].charAt(0).toUpperCase() + data[cols[2]].slice(1).toLowerCase();
        this.surname1 = data[cols[0]].charAt(0).toUpperCase() + data[cols[0]].slice(1).toLowerCase();
        this.surname2 = data[cols[1]].charAt(0).toUpperCase() + data[cols[1]].slice(1).toLowerCase();
        this.state = data[cols[4]];
        this.from = data[cols[5]];

        this.email = '';
        this.department = ''; // departamento didáctico (proyectos, medios, ...)
        this.departmentCode = ''; // cuerpo docente (522, 511...)        
        this.branch = '';
    }
    setIdx(idx) {
        this.id = idx;
    }

    addExtraData(email, department, departmentCode, especialidad) {
        this.email = email;
        this.department = department;
        this.departmentCode = departmentCode;
        this.branch = especialidad;
    }
 
}

module.exports = {
    Profesor,
};
