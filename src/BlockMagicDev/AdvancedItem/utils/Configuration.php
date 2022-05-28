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