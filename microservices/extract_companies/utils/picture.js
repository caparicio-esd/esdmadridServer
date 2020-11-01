const Excel = require('exceljs');
const path = require('path');
const fs = require('fs');

const extractAndSavePictures = async () => {
    /**
     * Load data
     */
    const rawFile = 'lista.xlsx';
    const rawPath = path.resolve(__dirname, "") + "/../data/raw/" + rawFile;
    const workbook = new Excel.Workbook();

    const file = await workbook.xlsx.readFile(rawPath);
    const sheet = file.getWorksheet('convenios');
    const pictures = [];

    sheet.getImages().forEach(image => {
        const pBuffer = file.media.find(m => m.index == image.imageId);

        const pictureUrl = "/data/clean/pictures/" + `${pBuffer.index}.${pBuffer.extension}`;
        const row = image.range.tl.nativeRow;
        const col = image.range.tl.nativeCol;
        const index = pBuffer.index;

        pictures.push({
            row, 
            col, 
            index, 
            pictureUrl
        });

        fs.writeFileSync(
            path.resolve(__dirname, "../") + pictureUrl, 
            pBuffer.buffer
        );
    });
    
    return pictures;
};

module.exports = {
    extractAndSavePictures
}
