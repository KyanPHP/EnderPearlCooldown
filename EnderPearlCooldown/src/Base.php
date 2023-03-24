<?php

namespace EnderPearlCooldown;

use pocketmine\scheduler\TaskHandler;
use pocketmine\plugin\Plugin;

class PlayerCooldownManager {

    private $playerCooldowns = [];

    public function setCooldownForPlayer(string $playerName, int $duration): void {
        if ($duration <= 0) {
            throw new \InvalidArgumentException("Duration must be greater than zero");
        }
        $this->playerCooldowns[$playerName] = time() + $duration;
    }

    public function getCooldownForPlayer(string $playerName): ?int {
        return $this->playerCooldowns[$playerName] ?? null;
    }

    public function removeCooldownForPlayer(string $playerName): bool {
        if (isset($this->playerCooldowns[$playerName])) {
            unset($this->playerCooldowns[$playerName]);
            return true;
        }
        return false;
    }

    public function getPlayersWithCooldowns(): array {
        $playersWithCooldowns = [];
        foreach ($this->playerCooldowns as $playerName => $cooldownEndsAt) {
            $timeRemaining = $cooldownEndsAt - time();
            if ($timeRemaining <= 0) {
                $this->removeCooldownForPlayer($playerName);
            } else {
                $playersWithCooldowns[$playerName] = $timeRemaining;
            }
        }
        return $playersWithCooldowns;
    }
}

class PlayerCooldownTaskHandler extends TaskHandler {

    private $updateInterval;

    public function __construct(Plugin $plugin, int $updateInterval) {
        parent::__construct($plugin);
        $this->updateInterval = $updateInterval;
    }

    public function setUpdateInterval(int $updateInterval): void {
        $this->updateInterval = $updateInterval;
    }

    public function onRun(int $currentTick): void {
        if (!$this->getTask()->isEnabled() || $this->getTask()->isCancelled()) {
            return;
        }
        $this->getTask()->updateCooldowns();
    }

    public function getUpdateInterval(): int {
        return $this->updateInterval;
    }
}

class PlayerCooldownTask implements \pocketmine\scheduler\Task {

    private $plugin;
    private $cooldownManager;
    private $taskHandler;

    public function __construct(Plugin $plugin, PlayerCooldownManager $cooldownManager) {
        $this->plugin = $plugin;
        $this->cooldownManager = $cooldownManager;
        $this->taskHandler = new PlayerCooldownTaskHandler($this->plugin, 20);
    }

    public function onRun(int $currentTick): void {
        $this->taskHandler->onRun($currentTick);
    }

    public function updateCooldowns(): void {
        foreach ($this->cooldownManager->getPlayersWithCooldowns() as $playerName => $timeRemaining) {
            $this->cooldownManager->setCooldownForPlayer($playerName, $timeRemaining);
        }
    }

    public function setUpdateInterval(int $updateInterval): void {
        $this->taskHandler->setUpdateInterval($updateInterval);
    }

    public function getUpdateInterval(): int {
        return $this->taskHandler->getUpdateInterval();
    }

    public function cancel(): void {
        $this->taskHandler->cancel();
    }
}