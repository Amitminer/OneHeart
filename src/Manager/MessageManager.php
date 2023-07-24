<?php

declare(strict_types=1);

namespace AmitxD\OneHeart\Manager;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as TF;

class MessageManager{
    
    public const PREFIX = TF::AQUA . "[" . TF::RED . "OneHeart" . TF::AQUA . "] ";
    public const USAGE = TF::RED . "Usage: /oneheart <join|setworld|list>";
    public const JOINED = TF::GREEN . "You have joined the OneHeart Challenge!";
    public const NOSUBCMD = TF::RED . "Unknown subcommand. " . self::USAGE;
    public const EXISTED_GAMEID = TF::RED . "The GameID '%gameId%' already exists in the config. Please choose a different GameID.";
    public const LEAVE_GAME = TF::YELLOW . "You have left the current game.";
    public const SETWORLD_USAGE = TF::RED . "Usage: /oneheart setworld <world> <GameID>";
    public const WORLD_ERROR = TF::RED . "An error occurred while loading world.";
    public const JOIN_USAGE = TF::RED . "Usage: /oneheart join <GameID>";
    public const GAMEID_NOT_EXIST = TF::RED . "The GameID '%gameId%' does not exist. Please check the GameID and try again.";

    public static function format(string $message, array $params = []): string {
        return str_replace(array_map(function($key){ return "%$key%"; }, array_keys($params)), $params, $message);
    }
}