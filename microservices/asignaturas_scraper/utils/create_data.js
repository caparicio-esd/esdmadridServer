/**
 * Create all asignaturas list
 */

const path = require("path");
const fs = require("fs");

const chalk = require("chalk");
const xlsx = require("xlsx");
const natural = require("natural");

const { Asignatura } = require("../classes/Asignatura");
const { getOptativas } = require("./optativas");
const { getAsignaturas } = require("./plan_estudios");

/**
 * Load data
 */
const dataRawPath = path.resolve(__dirname, "../data/raw");
const fileName = `${dataRawPath}/profes.xlsx`;
const workBook = xlsx.readFile(fileName, { type: "array" });
const workSheet = workBook.Sheets["TODO"];
const rawData = xlsx.utils.sheet_to_json(workSheet);

/**
 * Set globals
 */
const asignaturas = [];
let optativas = [];
let asignaturasPE = [];
let idx = 0;
let isFinal = false;

/**
 * Load optativa
 */
const setOptativas = async () => {
  optativas = await getOptativas();
};
const setAsignaturasPE = async () => {
  asignaturasPE = await getAsignaturas();
};

/**
 * Create instances
 */
const createInstances = () => {
  rawData.forEach((rd) => {
    const cachedAsignatura = new Asignatura(rd);
    const asignaturaPrev = asignaturas.find((as) => as.title == cachedAsignatura.title);

    if (!asignaturaPrev) {
      cachedAsignatura.setIdx(idx);
      asignaturas.push(cachedAsignatura);
      idx++;
    }
  });
};

/**
 * Relate optativas y asignaturas
 */
const relateOptativas = () => {
  rawData.forEach((rd) => {
    let asignatura = asignaturas.find((as) => as.title == rd["ASIGNATURA"].trim());

    if (asignatura) {
      const optativa = optativas.find((opt) => opt.courseRaw == asignatura.courseRaw);

      if (optativa) {
        asignatura.course = [...optativa.cursos.filter((a) => a != "M")];
        asignatura.ects = optativa.ects;
      }
    }
  });
};

/**
 * Set teachers
 */
const setTeachers = () => {
  rawData.forEach((rd) => {
    const asignatura = asignaturas.find((as) => as.title == rd["ASIGNATURA"].trim());

    if (asignatura && !asignatura.hasTeacher(rd["PROFESOR/A"].trim())) {
      asignatura.addTeacher(rd["PROFESOR/A"].trim());
    }
  });
};

/**
 * Set ects from PE scraping
 */
const setPlanEstudios = () => {
  let asignatura = null;
  asignaturasPE.forEach((asPe) => {
    asignatura = asignaturas.find((as) => {
      return natural.JaroWinklerDistance(as.title, asPe.title) > 0.9;
    });
    if (asignatura) {
      asignatura.ects = asPe.ects;
    }
  });
};

/**
 *
 */
const getData = async () => {
  console.log(chalk.green("Parsing Asignaturas..."));
  await setOptativas();
  await setAsignaturasPE();
  createInstances();
  relateOptativas();
  setTeachers();
  setPlanEstudios();

  return asignaturas;
};

module.exports = getData;
