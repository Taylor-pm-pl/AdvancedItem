<?php

declare(strict_types=1);

namespace BlockMagicDev\AdvancedItem\session;

use BlockMagicDev\AdvancedItem\Loader;
use BlockMagicDev\AdvancedItem\utils\Configuration;

use function time;

class Session {
	private string $type = "";

	private mixed $data;

	private int $time = 0;

	public function __construct(string $type, mixed $data) {
		$this->type = $type;
		$this->data = $data;
		$this->time = time() + Configuration::getInt(Loader::$config, 'Time-Confirm');
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