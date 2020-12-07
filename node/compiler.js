const fs = require("fs")
const fse = require("fs-extra")
const path = require("path")
const delDir = require("rimraf")

// set dirs
let dir = {
    sysDir: path.resolve(__dirname + "/../app"),
    installer: path.resolve(__dirname + "/../php_installer/install.php"),
    installerDumpDir: path.resolve(__dirname + "/../installer-dump"),
    installerFile: path.resolve(__dirname + "/../php_installer/install.php"),
    dbFile: path.resolve(__dirname + "/../docker/TD_dbExport/data/build-cms.sql")
}

new Promise((res, rej) => {
    if (fs.existsSync(dir.installerDumpDir)) {
        console.log("Deleting existing directory")
        res(delDir.sync(dir.installerDumpDir))
    }
    else {
        res(true)
    }
}).then(result => {
    console.log("Creating \"installer-dump\" directory")
    return fs.mkdirSync(dir.installerDumpDir)
}).then(result => {
    console.log("Creating \"sys\" directory")
    return fs.mkdirSync(dir.installerDumpDir + "/sys")
}).then(result => {
    console.log("Coping the cms to the \"sys\" directory")
    return fse.copy(dir.sysDir, dir.installerDumpDir + "/sys")
}).then(result => {
    console.log("Copying install.php")
    return fse.copy(dir.installerFile, dir.installerDumpDir + "/index.php")
}).then(result => {
    console.log("Copying database")
    return fse.copy(dir.dbFile, dir.installerDumpDir + "/db.sql")
}).then(result => {
    console.log("Done")
    process.exit()
})