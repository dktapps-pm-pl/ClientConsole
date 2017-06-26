<?php

namespace dktapps\ClientConsole;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	public function onEnable(){
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CheckConsoleTask($this), 1);
	}
}