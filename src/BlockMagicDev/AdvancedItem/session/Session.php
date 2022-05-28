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
use function time;

class Session {
	private string $type = "";

	private mixed $data;

	private int $time = 0;

	public function __construct(string $type, mixed $data) {
		$this->type = $type;
		$this->data = $data;
		$this->time = time() + Loader::getInstance()->config->getInt('Time-Confirm');
	}

	public function getType() : string {
		return $this->type;
	}

	public function getData() : mixed {
		return $this->data;
	}
	public function getTime() : int {
		return $this->time;
	}
}