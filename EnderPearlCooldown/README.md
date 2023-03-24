EnderPearlCooldown Plugin
This Minecraft plugin adds a cooldown for Ender Pearls, preventing players from using them too frequently. The plugin works by keeping track of each player's cooldown time in a fixed-size array and updating it every tick. If a player tries to use an Ender Pearl while their cooldown is active, the plugin will cancel the event.

Installation
To install the EnderPearlCooldown plugin, simply copy the EnderPearlCooldown.jar file into your server's plugins directory. You will also need to have a version of Minecraft that supports Bukkit or Spigot plugins.

Usage
Once the plugin is installed, players will automatically have a cooldown on Ender Pearls. The default cooldown time is 5 seconds, but you can change this by editing the cooldownDuration constant in the EnderPearlCooldown.php file.

Configuration
The EnderPearlCooldown plugin can be configured in the config.yml file, which is created automatically when the plugin is first run. The following options are available:

cooldownDuration - The duration of the Ender Pearl cooldown in seconds (default: 5)
logLevel - The logging level for the plugin (default: INFO)
Contributing
If you would like to contribute to the EnderPearlCooldown plugin, feel free to submit a pull request on GitHub. Please make sure that your code is well-documented and follows the PSR coding standards.

License
The EnderPearlCooldown plugin is released under the MIT License. See the LICENSE file for details.