<?php

namespace dktapps\ClientConsole;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\snooze\SleeperNotifier;

class Main extends PluginBase{
	/** @var ClientConsoleLoggerAttachment */
	private $loggerAttachment;

	public function onEnable() : void{
		$notifier = new SleeperNotifier();
		$buffer = new \Threaded();
		$this->loggerAttachment = new ClientConsoleLoggerAttachment($notifier, $buffer);

		$this->getServer()->getTickSleeper()->addNotifier($notifier, function() use ($buffer) : void{
			$server = $this->getServer();
			$targets = array_filter($server->getOnlinePlayers(), function(Player $player){
				return $player->hasPermission("clientconsole.receive");
			});

			while(($line = $buffer->shift()) !== null){
				/** @var string $line */
				$server->broadcastMessage($line, $targets);
			}
		});

		$this->getServer()->getLogger()->addAttachment($this->loggerAttachment);
	}

	public function onDisable() : void{
		$this->getServer()->getTickSleeper()->removeNotifier($this->loggerAttachment->getNotifier());
		$this->getServer()->getLogger()->removeAttachment($this->loggerAttachment);
	}
}
