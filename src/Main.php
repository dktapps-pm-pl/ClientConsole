<?php

namespace dktapps\ClientConsole;

use pmmp\thread\ThreadSafeArray;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\snooze\SleeperNotifier;

class Main extends PluginBase{
	private ClientConsoleLoggerAttachment $loggerAttachment;
	private int $notifierId;

	public function onEnable() : void{
		$buffer = new ThreadSafeArray();


		$sleeperEntry = $this->getServer()->getTickSleeper()->addNotifier(function() use ($buffer) : void{
			$server = $this->getServer();
			$targets = array_filter($server->getOnlinePlayers(), function(Player $player){
				return $player->hasPermission("clientconsole.receive");
			});

			while(($line = $buffer->shift()) !== null){
				/** @var string $line */
				$server->broadcastMessage($line, $targets);
			}
		});
		$this->notifierId = $sleeperEntry->getNotifierId();

		$this->loggerAttachment = new ClientConsoleLoggerAttachment($sleeperEntry, $buffer);
		$this->getServer()->getLogger()->addAttachment($this->loggerAttachment);
	}

	public function onDisable() : void{
		$this->getServer()->getTickSleeper()->removeNotifier($this->notifierId);
		$this->getServer()->getLogger()->removeAttachment($this->loggerAttachment);
	}
}
