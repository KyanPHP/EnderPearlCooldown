<?php

class CooldownManager {
    private $playerCooldowns = [];

    public function setPlayerCooldown(string $name, int $seconds) {
        $this->playerCooldowns[$name] = time() + $seconds;
    }

    public function isPlayerOnCooldown(string $name) {
        $cooldown = $this->playerCooldowns[$name] ?? null;
        return $cooldown !== null && $cooldown > time();
    }

    public function getPlayerCooldown(string $name) {
        $cooldown = $this->playerCooldowns[$name] ?? null;
        return $cooldown !== null ? max(0, $cooldown - time()) : 0;
    }

    public function onPlayerJoin(string $name) {
        if (!isset($this->playerCooldowns[$name])) {
            $cooldowns[$name] = 0;
        }
    }
}

class Main {
    private $cooldownManager;

    public function __construct() {
        $this->cooldownManager = new CooldownManager();
    }

    public function onCommand($sender, $cmd, $label, array $args) {
        if ($cmd === "mycommand") {
            $name = $sender->getName();
            if ($this->cooldownManager->isPlayerOnCooldown($name)) {
                $sender->sendMessage("You are on cooldown for " . $this->cooldownManager->getPlayerCooldown($name) . " seconds.");
            } else {
                // Execute command
                $this->cooldownManager->setPlayerCooldown($name, 60);
            }
            return true;
        }
        return false;
    }

    public function onPlayerJoin($event) {
        $name = $event->getPlayer()->getName();
        $this->cooldownManager->onPlayerJoin($name);
    }
}
