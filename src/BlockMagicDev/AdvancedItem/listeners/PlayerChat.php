<?php

declare(strict_types=1);

namespace BlockMagicDev\AdvancedItem\listeners;

use BlockMagicDev\AdvancedItem\Loader;
use BlockMagicDev\AdvancedItem\utils\Configuration;
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
		$msg = Loader::$messages;
		$message = $event->getMessage();
		$sessionMgr = Loader::getSessionManager();
		if ($message == 'yes') {
			if ($sessionMgr->getSession($player) !== null) {
				if ($sessionMgr->equalsTime($player, time())) {
					switch ($sessionMgr->getSession($player)->getType()) {
						case 'changename':
							ItemUtils::changeName($player, strval($sessionMgr->getSession($player)->getData()));
							$sessionMgr->removeSession($player);
							$event->cancel();
							$player->sendMessage(Configuration::getString($msg, 'messages.setname.success'));
							break;
						case 'setlore':
							ItemUtils::setLore($player, strval($sessionMgr->getSession($player)->getData()));
							$sessionMgr->removeSession($player);
							$event->cancel();
							$player->sendMessage(Configuration::getString($msg, 'messages.setlore.success'));
							break;
					}
				} else {
					$event->cancel();
					$player->sendMessage(Configuration::getString($msg, 'messages.timeout'));
				}
			}
		} elseif ($message == 'no') {
			if ($sessionMgr->getSession($player) !== null) {
				$event->cancel();
				$sessionMgr->removeSession($player);
				$player->sendMessage(Configuration::getString($msg, 'messages.cancel-success'));
			}
		}
	}
}