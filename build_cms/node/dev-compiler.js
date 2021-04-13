const compiler = require("./compiler")
const chokidar = require("chokidar")
const path = require("path")

compiler()

const chokidarWatchObject = {
    ignored: /(^|[\/\\])\../,
    persistent: true,
    ignoreInitial:true
}

// app dir
const watcherApp = chokidar.watch(
    path.resolve(`${__dirname}/../app`),
    chokidarWatchObject)

watcherApp.on("all", compiler)

// plugins dir
const watcherPlugins = chokidar.watch(
    path.resolve(`${__dirname}/../plugins`),
    chokidarWatchObject)

watcherPlugins.on("all", compiler)

// installer
const watcherPhpInstaller = chokidar.watch(
    path.resolve(`${__dirname}/../php_installer`),
    chokidarWatchObject)

watcherPhpInstaller.on("all", compiler)

// admin_basics
const watcherAdminBasics = chokidar.watch(
    path.resolve(`${__dirname}/../admin_basics`),
    chokidarWatchObject)

watcherAdminBasics.on("all", compiler)