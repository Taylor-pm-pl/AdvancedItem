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

namespace BlockMagicDev\AdvancedItem\listeners;

use BlockMagicDev\AdvancedItem\Loader;
use BlockMagicDev\AdvancedItem\session\Session;
use BlockMagicDev\AdvancedItem\utils\ItemUtils;
use Closure;
use pocketmine\event\EventPriority;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use function strval;
use function time;

class PlayerChat implements Listener {
	public function __construct(Loader $ai) {
		$pluginMgr = $ai->getServer()->getPluginManager();
		$pluginMgr->registerEvent(PlayerChatEvent::class, Closure::fromCallable([$this, 'onChat']), EventPriority::HIGHEST, $ai);
	}

	public function onChat(PlayerChatEvent $event) : void {
		$player = $event->getPlayer();
		$msg = Loader::getInstance()->messages;
		$message = $event->getMessage();
		$sessionMgr = Loader::getSessionManager();
		if ($message == 'yes') {
			if ($sessionMgr->getSession($player) instanceof Session) {
				if ($sessionMgr->equalsTime($player, time())) {
					switch ($sessionMgr->getSession($player)->getType()) {
						case 'changename':
							ItemUtils::changeName($player, strval($sessionMgr->getSession($player)->getData()));
							$sessionMgr->removeSession($player);
							$event->cancel();
							$player->sendMessage($msg->getString('messages.setname.success'));
							break;
						case 'setlore':
							ItemUtils::setLore($player, strval($sessionMgr->getSession($player)->getData()));
							$sessionMgr->removeSession($player);
							$event->cancel();
							$player->sendMessage($msg->getString('messages.setlore.success'));
							break;
					}
				} else {
					$event->cancel();
					$player->sendMessage($msg->getString('messages.timeout'));
				}
			}
		} elseif ($message == 'no') {
			if ($sessionMgr->getSession($player) !== null) {
				$event->cancel();
				$sessionMgr->removeSession($player);
				$player->sendMessage($msg->getString('messages.cancel-success'));
			}
		}
	}
}
