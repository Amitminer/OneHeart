<?php

namespace AmitxD\OneHeart\Manager;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use AmitxD\OneHeart\OneHeart;

class EventManager implements Listener {

    private $plugin;

    public function __construct(OneHeart $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $playersInOneHeart = $this->plugin->getPlayersInOneHeart();
        if (in_array($player->getName(), $playersInOneHeart)) {
            $this->plugin->setOneHeart($player);
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event): void {
        $player = $event->getPlayer();
        $playerName = $player->getName();
        $playersInOneHeart = $this->plugin->getPlayersInOneHeart();
        if (in_array($playerName, $playersInOneHeart)) {
            $this->plugin->removePlayer($player);
        }
    }
}