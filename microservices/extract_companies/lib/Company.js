const { extractId } = require('../utils/utilFns')


/**
 * class
 */
class Company {
    constructor(rawCompany, i) {
        this.offset = 5;
        this.raw = rawCompany;
        this.row = i;
        this.createProps();
        this.wrangleData();

        delete this.raw;
        this.exposeData();
    }

    /**
     * 
     */
    wrangleData() {
        this.cleanUpId();
        this.cleanUpEsp();
        this.cleanUpAddress();
        this.cleanUpWeb();
        this.cleanUpArrays();
    }

    /**
     * 
     */
    createProps() {
        this.raw.forEach((cell, i) => {
            switch (i) {
                case 0:
                    this.id = cell.value || '';
                    break;
                case 1:
                    this.especialidad = cell.value || '';
                    break;
                case 2:
                    this.name = cell.value || '';
                    break;
                case 3:
                    this.address01 = cell.value || '';
                    break;
                case 4:
                    this.address02 = cell.value || '';
                    break;
                case 5:
                    this.address03 = cell.value || '';
                    break;
                case 6:
                    this.address04 = cell.value || '';
                    break;
                case 7:
                    this.web = cell.value || '';
                    break;
                case 9:
                    this.objectives = cell.value || '';
                    break;
                case 10:
                    this.picture = '';
                    break;
            }
        });
    }

    cleanUpId() {
        this.id = extractId(this.id);
    }
    cleanUpEsp() {
        const cleanEsp = [
            { curr: 'M', new: 'moda' },
            { curr: 'P', new: 'producto' },
            { curr: 'G', new: 'grafico' },
            { curr: 'I', new: 'interiores' },
            { curr: 'MDI', new: 'mdi' },
            { curr: 'MEC', new: 'mec' }
        ];

        this.especialidad = this.especialidad.split(' ').join('');
        this.especialidad = this.especialidad.split(/(,|\/)/).filter(a => a != ',' && a != '/');
        this.especialidad = this.especialidad.map(esp => {
            const d = cleanEsp.find(c => c.curr == esp);
            return d ? d.new : '';
        }).sort();
        this.especialidad = this.especialidad.filter(e => e != '');
    }
    cleanUpAddress() {
        this.addressComp = this.address01 + " - " + this.address02;
    }
    cleanUpWeb() { 
        this.web = this.web.hyperlink;
    }
    cleanUpArrays() {
        const arrays = [
            'objectives'
        ];

        arrays.forEach(a => {
            this[a] = this[a].split('\n').filter(a => a != '');
        });
    }

    exposeData() {
        return Object.assign({}, {
            index: this.row + this.offset,
            id: this.id, 
            especialidad: this.especialidad,
            name: this.name,
            address: this.addressComp, 
            web: this.web,
            objectives: this.objectives, 
            picture: this.picture
        });
    }


}

module.exports = Company;
