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

namespace BlockMagicDev\AdvancedItem\utils;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function explode;

class ItemUtils {
	public static function checkItem(Player $player) : bool {
		$iditem = $player->getInventory()->getItemInHand()->getId();
		return $iditem !== 0;
	}

	public static function changeName(Player $player, string $newName) : void {
		$item = $player->getInventory()->getItemInHand();
		$item->setCustomName($newName);
		$player->getInventory()->setItemInHand($item);
	}

	public static function setLore(Player $player, string $combine) : void {
		$combine = explode(":", $combine);
		$line = $combine[0] ?? 1;
		$string = $combine[1] ?? "";
		$item = $player->getInventory()->getItemInHand();
		$newLore = [];
		foreach ($item->getLore() as $case => $lore) {
			$newLore[$case] = $lore;
		}
		for ($lineX = 0; $lineX < $line; $lineX++) {
			if (empty($newLore[$lineX])) {
				$newLore[$lineX] = "";
			}
		}
		$newLore[$line] = TextFormat::colorize("&r" . $string);
		$item->setLore($newLore);
		$player->getInventory()->setItemInHand($item);
	}
}