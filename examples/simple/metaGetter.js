window.onload=getExif;

function getExif() {
    var img1 = document.getElementById("img1");
    EXIF.getData(img1, function() {
        var make = EXIF.getTag(this, "Model");
        var makeAndModel = document.getElementById("model");
        makeAndModel.innerHTML = `${make}`;

        var crDate = EXIF.getTag(this, "DateTimeDigitized");
        var crDateDoc = document.getElementById("createDate");
        crDateDoc.innerHTML = `${crDate}`;

    var owNam = EXIF.getTag(this, "ExposureTime");
        var owNamDoc = document.getElementById("ownerName");
        owNamDoc.innerHTML = `${owNam}`;

        var lens = EXIF.getTag(this, "FNumber");
        var lensDoc = document.getElementById("lensMake");
        lensDoc.innerHTML = `${lens}`;

        var ex = EXIF.getTag(this, "ExposureProgram");
        var exDoc = document.getElementById("exposureProgram");
        exDoc.innerHTML = `${ex}`;

        var iso = EXIF.getTag(this, "ISOSpeedRatings");
        var isoDoc = document.getElementById("iso");
        isoDoc.innerHTML = `${iso}`;
    });
}

function getExif2() {
    var img1 = document.getElementById("img1");
    var make = EXIF.pretty(img1);
    var makeAndModel = document.getElementById("makeAndModel");
    makeAndModel.innerHTML = `${make}`;
}