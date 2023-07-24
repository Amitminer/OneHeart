<?php

declare(strict_types = 1);

namespace AmitxD\OneHeart;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use AmitxD\OneHeart\Manager\EventManager;
use AmitxD\OneHeart\Manager\MessageManager;
use pocketmine\utils\TextFormat as TF;

class OneHeart extends PluginBase {

    const HALF_HEART = 1;
    private $config;
    private $playersInOneHeart = [];

    public function onEnable(): void {
        $this->config = $this->getConfig();
        $this->saveDefaultConfig();
        $this->getLogger()->info("OneHeart mini-game plugin has been enabled!");
        $this->getServer()->getPluginManager()->registerEvents(new EventManager($this), $this);
    }
    
    public function getPlayersInOneHeart(): array {
        return $this->playersInOneHeart;
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        switch ($command->getName()) {
            case "oneheart":
                if (isset($args[0])) {
                    switch (strtolower($args[0])) {
                        case "join":
                            $this->JoinCommand($sender, $args);
                            break;
                        case "setworld":
                            $this->SetWorldCommand($sender, $args);
                            break;
                        case "quit":
                        case "left":
                        case "leave":
                            $this->leaveGame($sender);
                            break;
                        case "list":
                            $this->sendGameList($sender);
                            break;
                        default:
                            $sender->sendMessage(MessageManager::PREFIX . MessageManager::NOSUBCMD);
                    }
                } else {
                    $sender->sendMessage(MessageManager::PREFIX . MessageManager::USAGE);
                }
                break;
        }
        return true;
    }
    
    private function leaveGame(Player $player): void{
        $playerName = $player->getName();
        $playersInOneHeart = $this->getPlayersInOneHeart();
        if (in_array($playerName, $playersInOneHeart)) {
            $this->removePlayer($player);
        }
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->sendMessage(MessageManager::LEAVE_GAME);
    }
    
    private function SetWorldCommand(Player $player, array $args): void {
        if (count($args) === 3 && strtolower($args[0]) === "setworld") {
            $worldName = $args[1];
            $gameId = strtolower($args[2]);
            if ($this->config->getNested("games.$gameId") !== null) {
                $player->sendMessage(MessageManager::PREFIX  . MessageManager::format(MessageManager::EXISTED_GAMEID, ["gameId" => $gameId]));
                return;
            }
            $this->config->setNested("games.$gameId", $worldName);
            $this->config->save();

            $player->sendMessage(MessageManager::format(MessageManager::PREFIX . TF::GREEN . "Game world '%world%' has been set for GameID '%gameId%'.", ["world" => $worldName, "gameId" => $gameId]));
        } else {
            $player->sendMessage(MessageManager::SETWORLD_USAGE);
        }
    }

    private function JoinCommand(Player $player, array $args): void {
        if (count($args) === 2 && strtolower($args[0]) === "join") {
            $gameId = strtolower($args[1]);
            if ($this->config->getNested("games.$gameId") === null) {
                $player->sendMessage(MessageManager::PREFIX . MessageManager::format(MessageManager::GAMEID_NOT_EXIST, ["gameId" => $gameId]));
                return;
            }
            $worldName = $this->config->getNested("games.$gameId");
           // $player->sendMessage("done ");
            if ($this->checkWorld($player, $worldName)) {
                $this->addPlayer($player);
                $player->sendMessage(MessageManager::PREFIX . MessageManager::JOINED);
                $this->setOneHeart($player);
            } else {
                $player->sendMessage(MessageManager::WORLD_ERROR);
                return;
            }
        } else {
            $player->sendMessage(MessageManager::JOIN_USAGE);
        }
    }

    private function checkWorld(Player $player, string $worldName): bool {
        $worldManager = $this->getServer()->getWorldManager();
        if (!$worldManager->isWorldLoaded($worldName)) {
            $worldManager->loadWorld($worldName);
        }
        $world = $worldManager->getWorldByName($worldName);
        if ($world !== null) {
            $spawnPosition = $world->getSpawnLocation();
            if ($spawnPosition !== null) {
                $player->teleport($spawnPosition);
                $player->setSpawn($spawnPosition);
                return true;
            } else {
                $player->sendMessage(MessageManager::PREFIX . TF::RED . "Spawn point not found in the game world name: {$worldName}.");
                return false;
            }
        }
        return false;
    }
    public function setOneHeart(Player $player): void {
        $player->setMaxHealth(self::HALF_HEART);
        $player->setHealth(self::HALF_HEART);
    }
    public function addPlayer(Player $player): void {
        $this->playersInOneHeart[] = $player->getName();
    }

    public function removePlayer(Player $player): void {
        $playerName = $player->getName();
        $this->playersInOneHeart = array_diff($this->playersInOneHeart, [$playerName]);
    }

    private function sendGameList(Player $sender): void {
        $games = $this->config->get("games", []);
        $sender->sendMessage(MessageManager::PREFIX . TF::AQUA . "Total Games Available:");
        foreach ($games as $gameId => $worldName) {
            $sender->sendMessage(MessageManager::PREFIX . TF::GREEN . "- $gameId");
        }
    }
}
