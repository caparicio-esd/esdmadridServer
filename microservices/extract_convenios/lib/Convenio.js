/**
 * class
 */
class Convenio {
  constructor(rawConvenio) {
    this.id = rawConvenio[0].value;
    this.country = {
      esp: rawConvenio[1].value,
      int: rawConvenio[2].value,
    };
    this.city = {
      esp: rawConvenio[3].value,
      int: rawConvenio[4].value,
    };
    this.university = rawConvenio[5].value;
    this.link = rawConvenio[6].value.hyperlink;
    this.agreementType = {
      erasmus: rawConvenio[7].value,
      others: rawConvenio[8].value,
      ethnoTourism: rawConvenio[9].value,
    };
  }
}

module.exports = Convenio;
