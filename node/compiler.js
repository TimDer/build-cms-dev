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
    dbFile: path.resolve(__dirname + "/../docker/TD_dbExport/data/build-cms.json")
}

new Promise((res, rej) => {
    // delete dir if it already exists
    if (fs.existsSync(dir.installerDumpDir)) {
        console.log("Deleting existing directory")
        res(delDir.sync(dir.installerDumpDir))
    }
    else {
        res(true)
    }
}).then(result => {
    // create the installer dump dir
    console.log("Creating \"installer-dump\" directory")
    return fs.mkdirSync(dir.installerDumpDir)
}).then(result => {
    // create the sys dir
    console.log("Creating \"sys\" directory")
    return fs.mkdirSync(dir.installerDumpDir + "/sys")
}).then(result => {
    // copy the cms to the sys dir
    console.log("Coping the cms to the \"sys\" directory")
    return fse.copy(dir.sysDir + "/build_cms", dir.installerDumpDir + "/sys/build_cms")
}).then(result => {
    // copy the ".htaccess" file to the sys dir
    console.log("Coping the htaccess to the \"sys\" directory")
    return fse.copy(dir.sysDir + "/.htaccess", dir.installerDumpDir + "/sys/.htaccess")
}).then(result => {
    // create the database installer
    console.log("Copying database")
    return fse.copy(dir.dbFile, dir.installerDumpDir + "/db.json")
}).then(result => {
    // create the installer html
    console.log("Copying install.php")
    return fse.copy(dir.installerFile, dir.installerDumpDir + "/index.php")
}).then(result => {
    // the compiler is done
    console.log("Done")
    process.exit()
})