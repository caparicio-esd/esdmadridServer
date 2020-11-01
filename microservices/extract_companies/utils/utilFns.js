const extractId = (stringIn) => {
    return +String(stringIn).split(' ').slice(0, 1).join('')
};


module.exports = {
    extractId
}