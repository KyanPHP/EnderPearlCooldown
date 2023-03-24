<?php

namespace enderpearlcd\enderpearlcooldown;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class EnderpearlCooldown extends PluginBase implements Listener{

    /** @var Config */
    private $config;

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
    }

    public function onDisable(){
        $this->config->save();
    }

    public function onPlayerInteract(PlayerInteractEvent $event, $timeLeft§r§c){
        $player = $event->getPlayer();
        if($event->getItem()->getId() === 368 && !$player->hasPermission("enderpearlcooldown.bypass")){
            $cooldown = $this->config->get("cooldown", 36);
            $playerName = strtolower($player->getName());
            if(!$player->hasPermission("enderpearlcooldown.override")) if($this->config->exists($playerName)){
                $lastUsed = $this->config->get($playerName);
                if(time() - $lastUsed < $cooldown){
                    $timeLeft = $cooldown - (time() - $lastUsed);
                    $timeLeft§r§c;
                    $player->sendMessage("§cYou must wait §l§n$timeLeft§r§c seconds before using enderpearls again.");
                    $event->setCancelled();
                    return;
                }
            }
            $this->config->set($playerName, time());
        }
    }
}
