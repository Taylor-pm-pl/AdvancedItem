<?php

declare(strict_types=1);

namespace BlockMagicDev\AdvancedItem;

use BlockMagicDev\AdvancedItem\command\AdvancedItem;
use BlockMagicDev\AdvancedItem\listeners\PlayerChat;
use BlockMagicDev\AdvancedItem\session\SessionManager;
use BlockMagicDev\AdvancedItem\utils\Configuration;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use ReflectionException;

class Loader extends PluginBase {
	use SingletonTrait;

	public Configuration $config;

	public Configuration $messages;
	/**@var $sessions array<int, Session> */
	public array $sessions = [];

	protected function onLoad() : void {
		self::setInstance($this);
	}

	protected function onEnable() : void {
		$this->getServer()->getCommandMap()->register('advanceditem', new AdvancedItem($this));
		$this->saveResource('config.yml');
		$this->saveResource('messages.yml');
		$this->initListeners();
		$this->config = new Configuration($this->getDataFolder() . "config.yml", Configuration::YAML);
		$this->messages = new Configuration($this->getDataFolder() . "messages.yml", Configuration::YAML);
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
		$this->config = $this->config->getAll();
		$this->messages = $this->messages->getAll();
	}
}