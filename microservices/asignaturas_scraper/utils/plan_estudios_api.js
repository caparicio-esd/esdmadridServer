/**
 * Scraping asignatura
 */

const axios = require("axios");
const cheerio = require("cheerio");
const fs = require("fs");
const path = require("path");
const chalk = require("chalk");
const estudio = require("yargs").argv.g;
const courseData = require("../classes/Esp");
const { log } = require("console");

const planEstudiosURL = {
  grafico: "https://esdmadrid.es/plan-de-estudios-diseno-grafico/",
  producto: "https://esdmadrid.es/plan-de-estudios-diseno-de-producto/",
  interiores: "https://esdmadrid.es/plan-de-estudios-diseno-de-interiores/",
  moda: "https://esdmadrid.es/plan-de-estudios-diseno-de-moda/",
};

/**
 *
 */
const getType = (el) => {
  let type = "";
  if (el) {
    if (el.hasClass("basicas")) {
      type = "FB";
    }
    if (el.hasClass("especialidad")) {
      type = "OE";
    }
    if (el.hasClass("optativas")) {
      type = "OPT";
    }
    if (
      el.text().trim() == "Prácticas externas" ||
      el.text().trim() == "Trabajo Fin de grado" ||
      el.text().trim() == "Trabajo Fin de master" ||
      el.text().trim() == "Libre Configuración"
    ) {
      type = el.text().trim();
    }
  }
  return type;
};

/**
 * Web Scraper
 */
const getJustAsignaturas = async (write = false) => {
  /**
   * if argv is wrong...
   */
  if (planEstudiosURL[estudio] == undefined) {
    console.log(chalk.red(`Estudio ${estudio} does not exist... `));
    return false;
  } else {
    console.log(chalk.green(`Scrapeando ${estudio} de la web de la ESD`));
  }

  // stdout
  let data = [];

  /**
   *
   */
  const htmlData = await axios.get(planEstudiosURL[estudio]).then((d) => d.data);
  console.log(chalk.green(`Scrapeo terminado...`));

  const $ = cheerio.load(htmlData, { decodeEntities: true });
  const rows = $("table").find("tr");
  let initRow = 0;
  let endRow = 0;
  let eachCols = 3;

  /**
   *
   */
  rows.each((i, row) => {
    if ($(row).children("td").eq(0).text().trim() == "asignatura/ECTS") initRow = i + 1;

    if ($(row).children("td").eq(0).text().trim() == "TOTAL ECTS") endRow = i;
  });

  /**
   *
   */
  const actualRows = rows.slice(initRow, endRow);
  actualRows.each((i, row) => {
    const cells = $(row).find("td").slice(0, 11);
    const cellsData = [];

    cells.each((j, cell) => {
      if (j % eachCols == 0) {
        if (cells.eq(j).text().trim() != "") {
          cellsData.push({
            title: cells.eq(j).text().trim(),
            ects: +cells
              .eq(j + 1)
              .text()
              .trim(),
            course: Math.floor(j / eachCols) + 1,
            type: getType(cells.eq(j)),
          });
        }
      }
    });

    data = [...data, ...cellsData];
  });

  if (write) {
    const file = path.resolve(__dirname, "../data/clean") + "/asignaturas_" + estudio + ".json";
    fs.writeFile(file, JSON.stringify(data, null, 4), (err, data) => {});
    console.log(chalk.green(`Asignaturas guardadas`));
  }

  return data;
};

/**
 * From scraped stuff
 * Object builder
 */
const getAsignaturas = async () => {
  /**
   * if argv is wrong...
   */
  if (planEstudiosURL[estudio] == undefined) {
    console.log(chalk.red(`Estudio ${estudio} does not exist... `));
    return false;
  }

  // create object.
  const asignaturas = await getJustAsignaturas();
  const types = Object.entries(courseData[estudio].ectsDistribution).map((d) => d[0]);
  const courses = Array.from([...Array(courseData[estudio].courses).keys()]);

  courses.forEach((course) => {
    const asignaturas_ = [];

    courseData[estudio].asignaturas[course] = {
      course: course + 1,
      ects: courseData[estudio].ectsByCourse,
      content: [],
    };
    types.forEach((type) => {
      // Get asignaturas
      courseData[estudio].asignaturas[course].content = [
        ...asignaturas
          .filter((a) => a.course == course + 1 && a.type != "OPT")
          .sort((a, b) => {
            if (a.type == b.type) {
              return a.type.localeCompare(b.type);
            } else {
              return types.indexOf(a.type) - types.indexOf(b.type);
            }
          }),
      ];
      // get optativas
      courseData[estudio].asignaturas[course].content = [
        ...courseData[estudio].asignaturas[course].content,
        {
          title: "Optativas",
          type: "OPT",
          course: course + 1,
          ects: courseData[estudio].ectsByCourse - courseData[estudio].asignaturas[course].content.reduce((sum, as) => sum + as.ects, 0),
        },
      ];
    });
  });

  // populate distribution
  types.forEach((type) => {
    let count = 0;
    courses.forEach((course) => {
      courseData[estudio].asignaturas[course].content.forEach((as) => {
        if (as.type == type) count = count + as.ects;
      });
    });
    courseData[estudio].ectsDistribution[type] = count;
  });

  // cross validate with asignaturas global

  if (write) {
    const file = path.resolve(__dirname, "../data/clean") + "/" + estudio + ".json";
    fs.writeFile(file, JSON.stringify(courseData[estudio], null, 4), (err, data) => {});
  }

  return courseData[estudio];
};

/**
 *
 */
module.exports = {
  getJustAsignaturas,
  getAsignaturas,
};
