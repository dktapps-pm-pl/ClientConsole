<?php

namespace dktapps\ClientConsole;

use pocketmine\snooze\SleeperNotifier;

class ClientConsoleLoggerAttachment extends \ThreadedLoggerAttachment{

	/** @var \Threaded */
	protected $buffer;

	/** @var SleeperNotifier */
	private $notifier;

	public function __construct(SleeperNotifier $notifier, \Threaded $buffer){
		$this->notifier = $notifier;
		$this->buffer = $buffer;
	}

	public function getNotifier() : SleeperNotifier{
		return $this->notifier;
	}

	public function log($level, $message){
		$this->buffer[] = $message;
		$this->notifier->wakeupSleeper();
	}
}
