<?php

namespace enderpearlcd\enderpearlcooldown;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class PlayerEventListener implements Listener{

    /** @var EnderpearlCooldown */
    private $plugin;

    public function __construct(EnderpearlCooldown $plugin){
        $this->plugin = $plugin;
    }

    public function onPlayerJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $playerName = strtolower($player->getName());
        if($this->plugin->getConfig()->exists($playerName)){
            $this->plugin->getConfig()->remove($playerName);
        }
    }
}