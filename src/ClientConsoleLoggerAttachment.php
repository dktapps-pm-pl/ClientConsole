<?php

namespace dktapps\ClientConsole;

use pmmp\thread\ThreadSafeArray;
use pocketmine\snooze\SleeperHandlerEntry;
use pocketmine\snooze\SleeperNotifier;
use pocketmine\thread\log\ThreadSafeLoggerAttachment;
use function spl_object_hash;
use function spl_object_id;

class ClientConsoleLoggerAttachment extends ThreadSafeLoggerAttachment{
	/** @var SleeperNotifier[] */
	private static array $notifiers = [];

	/**
	 * @phpstan-param ThreadSafeArray<int, string> $buffer
	 */
	public function __construct(
		private SleeperHandlerEntry $sleeperEntry,
		private ThreadSafeArray $buffer
	){}

	public function log(string $level, string $message) : void{
		$this->buffer[] = $message;
		$notifier = self::$notifiers[spl_object_id($this)] ??= $this->sleeperEntry->createNotifier();
		$notifier->wakeupSleeper();
	}

	public function __destruct(){
		unset(self::$notifiers[spl_object_id($this)]);
	}
}
