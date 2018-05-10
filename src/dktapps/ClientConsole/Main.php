<?php

namespace dktapps\ClientConsole;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\snooze\SleeperNotifier;

class Main extends PluginBase{
	/** @var ClientConsoleLoggerAttachment */
	private $loggerAttachment;

	public function onEnable(){
		$notifier = new SleeperNotifier();
		$this->loggerAttachment = new ClientConsoleLoggerAttachment($notifier);

		$this->getServer()->getTickSleeper()->addNotifier($notifier, function() : void{
			$server = $this->getServer();
			$targets = array_filter($server->getOnlinePlayers(), function(Player $player){
				return $player->hasPermission("clientconsole.receive");
			});

			while(($line = $this->loggerAttachment->getLine()) !== null){
				$server->broadcastMessage($line, $targets);
			}
		});

		$this->getServer()->getLogger()->addAttachment($this->loggerAttachment);
	}

	public function onDisable(){
		$this->getServer()->getTickSleeper()->removeNotifier($this->loggerAttachment->getNotifier());
		$this->getServer()->getLogger()->removeAttachment($this->loggerAttachment);
	}
}
