<?php

namespace yournamespace\enderpearlcooldown;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

    public function onEnable(){
        $this->getLogger()->info("EnderPearlCooldown has been enabled!");

        // Register listener
        $this->getServer()->getPluginManager()->registerEvents(new EnderpearlCooldown($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener($this), $this);
    }

    public function onDisable(){
        $this->getLogger()->info("EnderPearlCooldown has been disabled!");
    }

}
