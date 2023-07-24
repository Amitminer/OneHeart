# OneHeart Plugin

![GitHub release (latest by date)](https://img.shields.io/github/v/release/Amitminer/OneHeart)
![GitHub license](https://img.shields.io/github/license/Amitminer/OneHeart)

OneHeart is a mini-game plugin for PocketMine-MP that challenges players to survive with only one heart (half a heart). Players can join different game worlds and test their survival skills in this intense and exciting game mode.

## Features

- Create and manage multiple game worlds.
- Players can join a game world with a specific GameID.
- Players spawn with only half a heart of health, making the game more challenging.
- Automatic health adjustment for players when they join the game.
- Customizable messages for various actions and events.
- Easy-to-use commands to manage the plugin and game worlds.

## Requirements

- PocketMine-MP API version 5.0.0
- PHP 8.1 or higher

## Installation

1. Download the latest release of the plugin from the [GitHub releases page](https://github.com/Amitminer/OneHeart/releases).
2. Place the `OneHeart.phar` file into the `plugins` folder of your PocketMine-MP server.
3. Restart your server to load the plugin.

## Commands

- `/oneheart join <GameID>` - Join a game world with the specified GameID.
- `/oneheart leave` - Leave the OneHeart challenge..
- `/oneheart setworld <world> <GameID>` - Set the game world for a specific GameID.
- `/oneheart list` - Show a list of available game worlds.

## Configuration

The configuration file `config.yml` is automatically generated in the `plugin_data/OneHeart` folder. You can customize various settings, such as messages and game worlds, in this file.

```yaml
# Example config.yml
games:
  game1: world_game1
  game2: world_game2
```

## Contributing

If you find a bug or want to suggest an improvement, please feel free to open an issue or submit a pull request. Your contributions are greatly appreciated!

## License

OneHeart Plugin is open-source software licensed under the [MIT License](LICENSE).

## Credits

The OneHeart plugin is created and maintained by [AmitxD] (https://github.com/Amitminer).

---
