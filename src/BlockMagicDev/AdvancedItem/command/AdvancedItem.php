<?php

/*
 *
 *  ____  _            _    __  __             _
 * |  _ \| |          | |  |  \/  |           (_)
 * | |_) | | ___   ___| | _| \  / | __ _  __ _ _  ___
 * |  _ <| |/ _ \ / __| |/ / |\/| |/ _` |/ _` | |/ __|
 * | |_) | | (_) | (__|   <| |  | | (_| | (_| | | (__
 * |____/|_|\___/ \___|_|\_\_|  |_|\__,_|\__, |_|\___|
 *                                       __/ |
 *                                      |___/
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author BlockMagicDev
 * @link https://github.com/BlockMagicDev/Advanceditem
 *
 *
*/

declare(strict_types=1);

namespace BlockMagicDev\AdvancedItem\command;

use BlockMagicDev\AdvancedItem\Loader;
use BlockMagicDev\AdvancedItem\utils\ItemUtils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;
use function array_shift;
use function implode;
use function strtolower;
use function strval;
use function trim;

class AdvancedItem extends Command implements PluginOwned {
	protected Loader $ai;

	public function __construct(Loader $ai) {
		$this->ai = $ai;
		parent::__construct('advanceditem');
		$this->setDescription("custom and improves items");
		$this->setPermission("advanceditem.allow.command");
		$this->setAliases(['ai', 'aitem']);
	}

	public function getOwningPlugin() : Plugin {
		return $this->ai;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void {
		$msg = Loader::getInstance()->messages;
		$config = Loader::getInstance()->config;
		if ($sender instanceof Player) {
			if (!ItemUtils::checkItem($sender)) {
				$sender->sendMessage($msg->getString('messages.item-not-found'));
				return;
			}
			if (isset($args[0])) {
				switch (strtolower($args[0])) {
					case "setname":
						if (!isset($args[1])) {
							$sender->sendMessage($msg->getString('messages.setname.usage'));
							return;
						}
						if ($config->getBool('Change-confirm')) {
							Loader::getSessionManager()->createSession($sender, 'changename', $args[1]);
							$sender->sendMessage($msg->getString('messages.confirm'));
							return;
						} else {
							ItemUtils::changeName($sender, strval($args[1]));
							$sender->sendMessage($msg->getString('messages.setname.success'));
							return;
						}
					case "setlore":
						if (!isset($args[2])) {
							$sender->sendMessage($msg->getString('messages.setlore.usage'));
							return;
						}
						$line = $args[1];
						unset($args[1]);
						array_shift($args);
						if ($config->getBool('Change-confirm')) {
							Loader::getSessionManager()->createSession($sender, 'setlore', $line . ":" . trim(implode(" ", $args)));
							$sender->sendMessage($msg->getString('messages.confirm'));
							return;
						} else {
							ItemUtils::setLore($sender, $line . ":" . trim(implode(" ", $args)));
							$sender->sendMessage($msg->getString('messages.setlore.success'));
							return;
						}
					case "duplicated":
						if ($config->getBool('Change-confirm')) {
							Loader::getSessionManager()->createSession($sender, 'duplicated', "null");
							$sender->sendMessage($msg->getString('messages.confirm'));
							return;
						} else {
							ItemUtils::Duplicated($sender);
							$sender->sendMessage($msg->getString('messages.duplicated.success'));
							return;
						}
					case "reload":
						$this->ai->reloadAll();
						$sender->sendMessage($msg->getString('messages.reload.success'));
						break;
				}
			} else {
				$sender->sendMessage(TextFormat::colorize("&b-- &aAvailable Commands &b--"));
				$sender->sendMessage(TextFormat::colorize("&d/advanceditem setname &b-&a Change name of item in hand!"));
				$sender->sendMessage(TextFormat::colorize("&d/advanceditem setlore &b-&a Change lore of item in hand!"));
				$sender->sendMessage(TextFormat::colorize("&d/advanceditem duplicated &b-&a Duplicated of item in hand!"));
				$sender->sendMessage(TextFormat::colorize("&d/advanceditem reload &b-&a Reload the config"));
			}
		}
	}
}
