using System;
using System.IO;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace compiler.Models.pluginsDir
{
    public class MockPluginDirRepo : IPluginsDirRepo
    {
        public List<PluginsDir> GetPluginDir()
        {
            var pluginDir = "/build_cms/plugins";
            var systemPluginDir = "/build_cms/system-plugins";

            string[] pluginDirContents = Directory.GetDirectories(pluginDir);
            string[] systemDirContents = Directory.GetDirectories(systemPluginDir);

            // create list
            List<PluginsDir> pluginList = new List<PluginsDir>();

            // add the plugin dir to the list
            foreach (string plugin in pluginDirContents)
            {
                var pluginName = new DirectoryInfo(plugin).Name;

                pluginList.Add(new PluginsDir()
                {
                    PluginPath = plugin,
                    PluginName = pluginName,
                    PluginType = "plugin"
                });
            }

            // add the system dir to the list
            foreach (string plugin in systemDirContents)
            {
                var pluginName = new DirectoryInfo(plugin).Name;

                pluginList.Add(new PluginsDir()
                {
                    PluginPath = plugin,
                    PluginName = pluginName,
                    PluginType = "system"
                });
            }

            return pluginList;
        }
    }
}
