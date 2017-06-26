<?php

namespace dktapps\ClientConsole;


use pocketmine\plugin\Plugin;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\MainLogger;
use pocketmine\utils\Terminal;
use pocketmine\utils\TextFormat;

class CheckConsoleTask extends PluginTask{

	/** @var ClientConsoleLoggerAttachment */
	protected $attachment;

	public function __construct(Plugin $owner){
		parent::__construct($owner);
		$this->attachment = new ClientConsoleLoggerAttachment();
		MainLogger::getLogger()->addAttachment($this->attachment);
	}

	public function onRun($currentTick){
		while($line = $this->attachment->getLine()){
			$this->getOwner()->getServer()->broadcastMessage(self::fromANSI((string) $line), $this->getOwner()->getServer()->getOnlinePlayers());
		}
	}

	public static function fromANSI(string $line) : string{
		return str_replace(
			[
				Terminal::$FORMAT_BOLD,
				Terminal::$FORMAT_OBFUSCATED,
				Terminal::$FORMAT_ITALIC,
				Terminal::$FORMAT_UNDERLINE,
				Terminal::$FORMAT_STRIKETHROUGH,
				Terminal::$FORMAT_RESET,

				Terminal::$COLOR_BLACK,
				Terminal::$COLOR_DARK_BLUE,
				Terminal::$COLOR_DARK_GREEN,
				Terminal::$COLOR_DARK_AQUA,
				Terminal::$COLOR_DARK_RED,
				Terminal::$COLOR_PURPLE,
				Terminal::$COLOR_GOLD,
				Terminal::$COLOR_GRAY,
				Terminal::$COLOR_DARK_GRAY,
				Terminal::$COLOR_BLUE,
				Terminal::$COLOR_GREEN,
				Terminal::$COLOR_AQUA,
				Terminal::$COLOR_RED,
				Terminal::$COLOR_LIGHT_PURPLE,
				Terminal::$COLOR_YELLOW,
				Terminal::$COLOR_WHITE
			],
			[
				TextFormat::BOLD,
				TextFormat::OBFUSCATED,
				TextFormat::ITALIC,
				TextFormat::UNDERLINE,
				TextFormat::STRIKETHROUGH,
				TextFormat::RESET,

				TextFormat::BLACK,
				TextFormat::DARK_BLUE,
				TextFormat::DARK_GREEN,
				TextFormat::DARK_AQUA,
				TextFormat::DARK_RED,
				TextFormat::DARK_PURPLE,
				TextFormat::GOLD,
				TextFormat::GRAY,
				TextFormat::DARK_GRAY,
				TextFormat::BLUE,
				TextFormat::GREEN,
				TextFormat::AQUA,
				TextFormat::RED,
				TextFormat::LIGHT_PURPLE,
				TextFormat::YELLOW,
				TextFormat::WHITE
			],
			$line
		);
	}
}