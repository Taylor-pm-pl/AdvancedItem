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

namespace BlockMagicDev\AdvancedItem\session;

use BlockMagicDev\AdvancedItem\Loader;
use pocketmine\player\Player;

class SessionManager {
	public function __construct() {
		//NOTHING
	}

	public function getSession(Player $player) : mixed {
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
