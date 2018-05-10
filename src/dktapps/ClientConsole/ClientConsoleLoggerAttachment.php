<?php

namespace dktapps\ClientConsole;

use pocketmine\snooze\SleeperNotifier;

class ClientConsoleLoggerAttachment extends \ThreadedLoggerAttachment{

	/** @var \Threaded */
	protected $buffer;

	/** @var SleeperNotifier */
	private $notifier;

	public function __construct(SleeperNotifier $notifier){
		$this->buffer = new \Threaded();
		$this->notifier = $notifier;
	}

	public function getNotifier() : SleeperNotifier{
		return $this->notifier;
	}

	public function log($level, $message){
		$this->buffer[] = $message;
		$this->notifier->wakeupSleeper();
	}

	/**
	 * @return string|null
	 */
	public function getLine() : ?string{
		return $this->buffer->shift();
	}

}
