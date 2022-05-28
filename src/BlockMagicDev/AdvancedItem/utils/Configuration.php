<?php

declare(strict_types=1);

namespace BlockMagicDev\AdvancedItem\utils;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use function boolval;
use function intval;
use function strval;

class Configuration {
	public static function getString(Config $file, string $key) : string {
		$result = TextFormat::colorize(strval($file->getNested($key, $key)));
		return $result;
	}

	public static function getBool(Config $file, string $key) : bool {
		$result = boolval($file->get($key, true));
		return $result;
	}

	public static function getInt(Config $file, string $key) : int {
		$result = intval($file->get($key, 0));
		return $result;
	}
}