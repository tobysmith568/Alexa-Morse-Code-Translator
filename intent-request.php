<?php

if (str_replace('/', '\\', __FILE__) == str_replace('/', '\\', $_SERVER['SCRIPT_FILENAME'])) {
	http_response_code(400);
	die();
}

class IntentRequestBuilder {
	
	private $result;
	
	public function __construct() {
		$this->result = new stdclass();
	}		
	
	public function build() {
		return $this->result;
	}		
	
	public function addPlainText($text) {
		$outputSpeech = new stdclass();
		
		$outputSpeech->type = 'PlainText';
		$outputSpeech->text = $text;
		$this->result->outputSpeech = $outputSpeech;

		return $this;	
	}
	
	public function addSSML($ssml) {
		$outputSpeech = new stdclass();
		
		$outputSpeech->type = 'SSML';
		$outputSpeech->ssml = $ssml;
		$this->result->outputSpeech = $outputSpeech;
		
		return $this;
	}
	
	public function addSimpleCard($title, $text) {
		$card = new stdclass();
		
		$card->type = 'Simple';
		$card->title = $title;
		
		$card->content = $text;
		
		$this->result->card = $card;
		
		return $this;
	}
}