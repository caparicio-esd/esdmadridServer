/**
 * Creación de objeto asignatura
 */

const cols = [
  "__rowNum__",
  "PROFESOR/A",
  "CORREO",
  "ESP. DOCENTE",
  "DEPARTAMENTO",
  "CÓDIGO ASIGNATURA",
  "ASIGNATURA",
  "GRUPO",
  "TURNO",
  "ESPECIALIDAD",
  "CARÁCTER",
  "SEMESTRE",
];

class Asignatura {
  constructor(data, id = 0) {
    this.id = id;
    this.title = data[cols[6]].trim();
    this.type = data[cols[10]];
    this.department = data[cols[4]]; // departamento didáctico
    this.departmentCode = data[cols[3]]; // cuerpo docente
    this.branch = data[cols[9]]; // especialidad
    this.courseRaw = data[cols[5]];
    this.course = [];
    this.semester = data[cols[11]];
    this.teachers = [];
    this.isMaster = data[cols[7]] == "Me" || data[cols[7]] == "Mi";
    this.isOpt = this.type == "OPT";
    this.ects = 4;

    this.setCourse(data, cols);
  }

  setIdx(idx) {
    this.id = idx;
  }

  setCourse(data, cols) {
    if (this.isMaster) {
      // master
      this.course.push(data[cols[7]]);
    }
    if (!this.isMaster && this.type == "OE") {
      // OE
      this.course.push(+this.courseRaw[2]);
    }
    if (!this.isMaster && this.type == "FB") {
      // FB
      this.course.push(+this.courseRaw[2]);
    }
  }

  addTeacher(teacher) {
    this.teachers.push(teacher);
    this.teachers.sort();
  }

  hasTeacher(teacher) {
    return this.teachers.includes(teacher);
  }

  addGroup(group) {
    this.groups.push(group);
  }

  printBeautifulOutput() {}
}

module.exports = {
  Asignatura,
};
