<?php

namespace EnderPearlCooldown;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;
use InvalidArgumentException;

class EventListener implements Listener {

    /** @var int[] */
    private $cooldowns = [];

    public function onPlayerInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $type = $item->getId();

        $remaining = $this->getCooldown($player, $type);
        if ($remaining === null || $remaining <= 0) {
            // player is not on cooldown
            $this->setCooldown($player, $type);
            // do something with the item
        } else {
            // player is on cooldown
            $player->sendMessage("Item on cooldown for " . $remaining . " seconds.");
        }
    }

    /**
     * Get the remaining cooldown for a player and item type.
     *
     * @param Player $player
     * @param int $type
     *
     * @return int|null The remaining cooldown in seconds, or null if the player has no cooldown for the type.
     */
    private function getCooldown(Player $player, int $type): ?int {
        $cooldowns = $this->cooldowns[$player->getUniqueId()->toString()] ?? [];
        $remaining = $cooldowns[$type] ?? null;

        if ($remaining === null || $remaining <= 0) {
            return null;
        }

        return $remaining - time();
    }

    /**
     * Set the cooldown for a player and item type.
     *
     * @param Player $player
     * @param int $type
     * @param int|null $duration The duration of the cooldown in seconds, or null to remove the cooldown.
     *
     * @throws InvalidArgumentException If the duration is not a positive integer or null.
     */
    private function setCooldown(Player $player, int $type, ?int $duration = 5): void {
        if ($player === null) {
            throw new InvalidArgumentException("Player cannot be null");
        }

        if (!is_int($duration) || $duration < 1) {
            throw new InvalidArgumentException("Duration must be a positive integer or null");
        }

        if ($player->isOnline()) {
            $cooldowns = $this->cooldowns[$player->getUniqueId()->toString()] ?? [];

            if (!isset($cooldowns[$type]) || $cooldowns[$type] < time()) {
                if ($duration === null) {
                    unset($cooldowns[$type]);
                } else {
                    $cooldowns[$type] = time() + $duration;
                }

                $this->cooldowns[$player->getUniqueId()->toString()] = $cooldowns;
            }
        }
    }
}
