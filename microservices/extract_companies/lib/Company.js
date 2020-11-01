const { fieldsRelations } = require('./../utils/data');
const { extractId } = require('./../utils/utilFns');

/**
 * class
 */
class Company {
    constructor(rawCompany, fieldsRelations) {
        this.raw = rawCompany;
        this.fieldsRelations = fieldsRelations;
        this.rawProps = {}
        this.init();
    }

    /**
     * 
     */
    init() {
        this.setRawProps();
        this.cleanUpStrings();
        this.cleanUpArrays();
        this.cleanUpNumbers();
        this.cleanUpEspecialidad();
        this.cleanProps();
    }

    /**
     * 
     */
    setRawProps() {
        Object.entries(this.raw).forEach(prop => {
            const fieldName = this.fieldsRelations.find(f => f.id == prop[0])
            this.rawProps[fieldName.field] = prop[1];
        });
    }

    /**
     * 
     */
    cleanUpStrings() {
        const cleanAsString = [
            'numeroDeConvenio', 'empresa', 'especialidad',
            'direccionPostalDeLaEmpresaRazonSocial',
            'codigoPostal', 'web',
            'direccionPostalDeLaEmpresaCentroDePracticas'
        ];

        Object.entries(this.rawProps).forEach(prop => {
            const isString = cleanAsString.includes(prop[0]);
            if (isString) {
                this.rawProps[prop[0]] = prop[1] ? String(prop[1]).split('\r\n').join(' ').trim() : '';
            }
        });
    }

    /**
     * 
     */
    cleanUpArrays() {
        const cleanAsArray = [
            'actividadesFormativasRelacionadas',
            'competenciasTransversales',
            'competenciasGenerales',
            'competenciasEspecificas'
        ];

        Object.entries(this.rawProps).forEach(prop => {
            const isArray = cleanAsArray.includes(prop[0]);

            if (isArray) {
                this.rawProps[prop[0]] = String(prop[1]).split('\r\n').filter(c => c != '').map(c => c.split('\r\n').join(' ').trim());
            }
        });
    }

    /**
     * 
     */
    cleanUpNumbers() {
        const cleanAsNumber = [
            'numeroDeConvenio'
        ];
        Object.entries(this.rawProps).forEach(prop => {
            const isNumber = cleanAsNumber.includes(prop[0]);

            if (isNumber) {
                this.rawProps[prop[0]] = extractId(prop[1]);
            }
        });
    }

    /**
     * 
     */
    cleanUpEspecialidad() {
        const especialidad = [
            { curr: "G", new: "grafico" },
            { curr: "M", new: "moda" },
            { curr: "P", new: "producto" },
            { curr: "I", new: "interiores" },
            { curr: "MDI", new: "mdi" },
            { curr: "MEC", new: "mec" }
        ];

        const sp = especialidad.find(e => this.rawProps.especialidad == e.curr);
        if (sp) {
            this.rawProps.especialidad = sp.new;
        }
    }

    /**
     * 
     */
    cleanProps() {
        const changePropNames = [
            {
                current: 'direccionPostalDeLaEmpresaRazonSocial',
                new: 'addressCompany'
            }, {
                current: 'direccionPostalDeLaEmpresaCentroDePracticas',
                new: 'addressPractica'
            }, {
                current: 'actividadesFormativasRelacionadas',
                new: 'goals'
            }, {
                current: 'competenciasTransversales',
                new: 'compsT'
            }, {
                current: 'competenciasGenerales',
                new: 'compsG'
            }, {
                current: 'competenciasEspecificas',
                new: 'compsE'
            }, {
                current: 'numeroDeConvenio',
                new: 'id'
            }
        ];

        Object.entries(this.rawProps).forEach(prop => {
            const changingProp = changePropNames.find(f => f.current == prop[0]);

            if (changingProp) {
                this[changingProp.new] = prop[1];
            } else {
                this[prop[0]] = prop[1];
            }
        });

        delete this.raw;
        delete this.rawProps;
    }

    /**
     * 
     */
    exposeProps() {
        const objOut = {};
        const propsToExpose = [
            'id',
            'especialidad',
            'empresa',
            'picture'
        ];

        propsToExpose.forEach(p => objOut[p] = this[p] || '');
        return objOut;
    }
}

module.exports = Company;
