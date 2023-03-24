<?php

declare(strict_types=1);

namespace enderpearlcooldown;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\ItemIds;

class PlayerEventListener implements Listener {

    /** @var EnderpearlCooldown */
    private $plugin;

    /** @var CooldownManager */
    private $cooldownManager;

    public function __construct(EnderpearlCooldown $plugin) {
        $this->plugin = $plugin;
        $this->cooldownManager = new CooldownManager();
    }

    public function onPlayerInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($item->getId() === ItemIds::ENDER_PEARL) {
            if ($this->cooldownManager->isOnCooldown($player)) {
                $player->sendMessage("You are still on cooldown for " . $this->cooldownManager->getCooldownRemaining($player) . " seconds.");
                $event->setCancelled();
                return;
            }
            $this->cooldownManager->startCooldown($player, 36);
        }
    }

}