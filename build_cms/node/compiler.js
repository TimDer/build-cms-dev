module.exports = (async () => {
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
    
    
    // delete dir if it already exists
    if (fs.existsSync(dir.installerDumpDir)) {
        console.log("Deleting existing directory")
        delDir.sync(dir.installerDumpDir)
    }
    // create the installer dump dir
    console.log("Creating \"installer-dump\" directory")
    fs.mkdirSync(dir.installerDumpDir)
    
    // create the sys dir
    console.log("Creating \"sys\" directory")
    fs.mkdirSync(dir.installerDumpDir + "/sys")
    
    // copy the cms to the sys dir
    console.log("Coping the cms to the \"sys\" directory")
    await fse.copy(dir.sysDir + "/build_cms", dir.installerDumpDir + "/sys/build_cms")
    
    // copy the ".htaccess" file to the sys dir
    console.log("Coping the htaccess to the \"sys\" directory")
    await fse.copy(dir.sysDir + "/.htaccess", dir.installerDumpDir + "/sys/.htaccess")
    
    // create the database installer
    console.log("Copying database")
    await fse.copy(dir.dbFile, dir.installerDumpDir + "/db.json")
    
    // create the installer html
    console.log("Copying install.php")
    await fse.copy(dir.installerFile, dir.installerDumpDir + "/index.php")

    // the compiler is done
    console.log("Done")
    process.exit()
});