<?php

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