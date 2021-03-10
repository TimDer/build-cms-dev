using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace compiler.Models.pluginsDir
{
    public interface IPluginsDirRepo
    {
        List<PluginsDir> GetPluginDir();
    }
}
