<?php

namespace dktapps\ClientConsole;


class ClientConsoleLoggerAttachment extends \ThreadedLoggerAttachment{

	/** @var \Threaded */
	protected $buffer;

	public function __construct(){
		$this->buffer = new \Threaded();
	}

	public function log($level, $message){
		$this->buffer[] = $message;
	}

	/**
	 * @return bool|string
	 */
	public function getLine(){
		return $this->buffer->shift();
	}

}