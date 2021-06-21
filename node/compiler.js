module.exports = () => {
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
        dbFile: path.resolve(__dirname + "/../docker/TD_dbExport/data/build-cms.json"),
        pluginDir: path.resolve(__dirname + "/../plugins/user"),
        pluginSystemDir: path.resolve(__dirname + "/../plugins/system"),
        adminTemplateDir: path.resolve(__dirname + "/../backend-template")
    }
    
    console.log("------------------------------------------------------------------")
    // delete dir if it already exists
    if (fs.existsSync(dir.installerDumpDir)) {
        console.log("Deleting existing directory")
        delDir.sync(dir.installerDumpDir + "/build_cms/*");
        delDir.sync(dir.installerDumpDir + "/build_cms/.*");

        if (fs.existsSync(dir.installerDumpDir + "/.htaccess")) {
            fs.unlinkSync(dir.installerDumpDir + "/.htaccess");
        }

        if (fs.existsSync(dir.installerDumpDir + "/index.php")) {
            fs.unlinkSync(dir.installerDumpDir + "/index.php");
        }
    }
    else {
        // create the installer dump dir
        console.log("Creating \"installer-dump\" directory")
        fs.mkdirSync(dir.installerDumpDir)
    }
    
    // copy the cms to the installer-dump dir
    console.log("Coping the cms to the \"installer-dump\" directory")
    fse.copySync(dir.sysDir + "/build_cms", dir.installerDumpDir + "/build_cms")

    // copy the cms backend template the the installer-dump dir
    console.log("Coping the backend template to the \"installer-dump\" dir")
    fse.copySync(dir.adminTemplateDir + "/view", dir.installerDumpDir + "/build_cms/build_cms_system/view/admin/admin_basics")
    fse.copySync(dir.adminTemplateDir + "/www-root", dir.installerDumpDir + "/build_cms/build_cms_system/www-root/admin/admin_basics")

    // copy the user plugins to the installer-dump dir
    if (fs.existsSync(dir.pluginDir)) {
        console.log("Coping the user plugins to the plugins directory")
        fse.copySync(dir.pluginDir, dir.installerDumpDir + "/build_cms/plugins")
    }

    // copy the system plugins to the installer-dump dir
    if (fs.existsSync(dir.pluginSystemDir)) {
        console.log("Coping the system plugins to the build_cms_system/system directory")
        fse.copySync(dir.pluginSystemDir, dir.installerDumpDir + "/build_cms/build_cms_system/system")
    }
    
    // copy the ".htaccess" file to the installer-dump dir
    console.log("Coping the htaccess to the \"installer-dump\" directory")
    fse.copySync(dir.sysDir + "/.htaccess", dir.installerDumpDir + "/.htaccess")

    // copy the "index.compile.php" file to the installer-dump dir
    console.log("Coping index.compile.php to the \"installer-dump\" directory")
    fse.copySync(dir.sysDir + "/index.compile.php", dir.installerDumpDir + "/index.php")

    // the compiler is done
    console.log("Done")
};
