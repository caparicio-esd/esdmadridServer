const defaultConfig = require("./node_modules/@wordpress/scripts/config/webpack.config");
const glob = require("glob");
const path = require("path");


const getEntries = (folder) => {
    const objOut = {};
    glob.sync(folder).forEach(p => { 
        objOut[p.replace('admin/reusable_blocks/src/', '')] = p
    });
    return objOut;
};


module.exports = {
    ...defaultConfig,
    entry: getEntries('./admin/reusable_blocks/**/*.js'),
    output: {
        path: path.resolve(__dirname, "./admin/reusable_blocks/dist/"),
        publicPath: '/',
        filename: '[name]'
    }
};