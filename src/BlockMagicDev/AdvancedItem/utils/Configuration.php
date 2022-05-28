<?php

declare(strict_types=1);

namespace BlockMagicDev\AdvancedItem\utils;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use function boolval;
use function intval;
use function strval;

class Configuration extends Config {
	public function getString(string $key) : string {
		$result = TextFormat::colorize(strval($this->getNested($key, $key)));
		return $result;
	}

	public function getBool(string $key) : bool {
		$result = boolval($this->get($key, true));
		return $result;
	}

	public function getInt(string $key) : int {
		$result = intval($this->get($key, 0));
		return $result;
	}
}