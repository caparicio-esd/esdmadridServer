const fs = require("fs");
const path = require("path");

// const { extractAndSaveData } = require('./utils/data');
const { extractAndSaveData } = require("./utils/data");
const { extractAndSavePictures } = require("./utils/picture");

/**
 *
 */
const writeData = true;

/**
 *
 */
const init = async () => {
  const pictures = await extractAndSavePictures();
  const companies = await extractAndSaveData();

  const finalCompanies = joinPicturesCompanies({ pictures, companies });
  createCompaniesByEsp(finalCompanies);
};

/**
 *
 */
const joinPicturesCompanies = ({ pictures, companies }) => {
  companies = companies.map((company) => {
    const picture = pictures.find((p) => p.row == company.index);
    return {
      ...company,
      picture: picture ? picture.pictureUrl : "",
    };
  });

  if (writeData) {
    fs.writeFileSync(path.resolve(__dirname, "") + "/data/clean/" + "companies.json", JSON.stringify(companies, null, 4), () => {});
  }

  return companies;
};

const createCompaniesByEsp = (finalCompanies) => {
  //
  const especialidades = [];
  finalCompanies.forEach((fc) => {
    fc.especialidad.forEach((es) => {
      if (!especialidades.includes(es)) especialidades.push(es);
    });
  });

  //
  especialidades.forEach((especialidad) => {
    const companiesToExport = finalCompanies.filter((fc) => {
      return fc.especialidad.includes(especialidad);
    });

    if (writeData) {
      fs.writeFileSync(
        path.resolve(__dirname, "") + "/data/clean/" + especialidad + ".json",
        JSON.stringify(companiesToExport, null, 4),
        () => {},
      );
    }
  });
};

/**
 * ;)
 */
init();
