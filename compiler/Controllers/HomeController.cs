using compiler.Models;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;
using compiler.Models.pluginsDir;
using compiler.ViewModels.pluginDir;

namespace compiler.Controllers
{
    public class HomeController : Controller
    {
        public IPluginsDirRepo PluginsDir { get; set; }
        public HomeController(IPluginsDirRepo pluginDir)
        {
            PluginsDir = pluginDir;
        }

        public IActionResult Index()
        {
            PluginDirViewModel pluginDirData = new PluginDirViewModel
            {
                PluginDirs = PluginsDir.GetPluginDir()
            };

            return View(pluginDirData);
        }

        [HttpPost]
        public IActionResult IndexPost()
        {
            return RedirectToAction("Index");
        }

        public IActionResult Info()
        {
            return View();
        }
    }
}
