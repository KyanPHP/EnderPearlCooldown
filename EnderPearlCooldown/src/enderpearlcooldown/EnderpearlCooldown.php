<?php

declare(strict_types=1);

namespace enderpearlcooldown;

use pocketmine\plugin\PluginBase;

class EnderpearlCooldown extends PluginBase {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener($this), $this);
    }

}
