const fs = require('fs');
const path = require('path');

const { extractAndSaveData } = require('./utils/data');
const { extractAndSavePictures } = require('./utils/picture');


/**
 * Entry point for pictures
 */
extractAndSavePictures();


/**
 * Entry point for data
 */
extractAndSaveData();



