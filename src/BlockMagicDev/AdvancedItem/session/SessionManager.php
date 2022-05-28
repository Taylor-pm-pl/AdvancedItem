<?php

declare(strict_types=1);

namespace BlockMagicDev\AdvancedItem\session;

use BlockMagicDev\AdvancedItem\Loader;
use pocketmine\player\Player;

class SessionManager {
	public function __construct() {
		//NOTHING
	}

	public function getSession(Player $player) : Session|null {
		$xuid = $player->getXuid();
		if (isset(Loader::getInstance()->sessions[$xuid])) {
			return Loader::getInstance()->sessions[$xuid];
		} else {
			return null;
		}
	}


	public function createSession(Player $player, string $type, mixed $data) : void {
		$xuid = $player->getXuid();
		if (!isset(Loader::getInstance()->sessions[$xuid])) {
			Loader::getInstance()->sessions[$xuid] = new Session($type, $data);
		}
	}

	public function removeSession(Player $player) : void {
		unset(Loader::getInstance()->sessions[$player->getXuid()]);
	}

	public function equalsTime(Player $player, int $time) : bool {
		$session = $this->getSession($player);
		if ($session instanceof Session) {
			if (($session->getTime() - $time) > 0) {
				return true;
			} else {
				return false;
			}
		}
		$this->removeSession($player);
		return false;
	}
}