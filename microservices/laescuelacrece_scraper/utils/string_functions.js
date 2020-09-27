


module.exports = function () {

    /**
     * String Prototypes
     */
    String.prototype.capitalize01 = function () {
        return this.split(' ').map(t => t[0] + t.slice(1).toLowerCase()).join(' ');
    };



    /**
     * String Prototypes
     */
    String.prototype.capitalize02 = function () {
        const out = this.split(' / ');
        const pais = ((pais) => {
            if (pais) {
                if (!pais.includes('–')) {
                    pais = pais[0] + pais.slice(1).toLowerCase();
                    pais = pais == 'Uk' ? 'UK' : pais;
                    pais = pais == 'Eeuu' ? 'EEUU' : pais;

                    return pais;
                } else {
                    pais = pais.replace('/', '');
                    pais = pais.split('–').map(t => t[0] + t.slice(1).toLowerCase()).join('-');
                    pais = pais.split('-').map(t => t == 'Uk' ? 'UK' : t).join('-');
                    pais = pais.split('-').map(t => t == 'Eeuu' ? 'EEUU' : t).join('-');

                    return pais;
                }
            }
        })(out[1]);

        return {
            name: out[0].split(' ').map(t => t[0] + t.slice(1).toLowerCase()).join(' '),
            pais
        };
    };

};




