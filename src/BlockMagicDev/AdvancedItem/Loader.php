<?php

declare(strict_types=1);

namespace BlockMagicDev\AdvancedItem;

use BlockMagicDev\AdvancedItem\command\AdvancedItem;
use BlockMagicDev\AdvancedItem\listeners\PlayerChat;
use BlockMagicDev\AdvancedItem\session\SessionManager;
use BlockMagicDev\AdvancedItem\utils\Configuration;
use pocketmine\plugin\PluginBase;
use ReflectionException;

class Loader extends PluginBase {
	public static Configuration $config;

	public static Configuration $messages;

	public static array $sessions;

	public function onEnable() : void {
		$this->getServer()->getCommandMap()->register('advanceditem', new AdvancedItem($this));
		$this->saveResource('config.yml');
		$this->saveResource('messages.yml');
		$this->initListeners();
		self::$config = new Configuration($this->getDataFolder() . "config.yml", Configuration::YAML);
		self::$messages = new Configuration($this->getDataFolder() . "messages.yml", Configuration::YAML);
	}

	private function initListeners() : void {
		try {
			new PlayerChat($this);
		} catch (ReflectionException $exception) {
			$this->getLogger()->critical($exception->getMessage());
			$this->getServer()->getPluginManager()->disablePlugin($this);
		}
	}

	public static function getSessionManager() : SessionManager {
		return new SessionManager();
	}

	public function reloadAll() : void {
		$this->reloadConfig();
		self::$config = self::$config->getAll();
		self::$messages = self::$messages->getAll();
	}
}