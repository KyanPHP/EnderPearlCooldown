<?php

declare(strict_types=1);

namespace enderpearlcooldown;

use pocketmine\Player;

class CooldownManager {

    /** @var array<string, int> */
    private $cooldowns = [];

    public function startCooldown(Player $player, int $seconds): void {
        $this->cooldowns[$player->getName()] = time() + $seconds;
    }

    public function isOnCooldown(Player $player): bool {
        return isset($this->cooldowns[$player->getName()]) && time() < $this->cooldowns[$player->getName()];
    }

    public function getCooldownRemaining(Player $player): int {
        return $this->cooldowns[$player->getName()] - time();
    }

    public function clearCooldown(Player $player): void {
        unset($this->cooldowns[$player->getName()]);
    }

}