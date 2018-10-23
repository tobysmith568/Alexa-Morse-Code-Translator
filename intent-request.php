<?php

if (str_replace('/', '\\', __FILE__) == str_replace('/', '\\', $_SERVER['SCRIPT_FILENAME'])) {
	http_response_code(400);
	die();
}

class IntentRequestBuilder {
	
	private $body;	
	private $result;
	
	public function __construct() {
		$this->body = new stdclass();
		$this->body->version = '1.0';
		
		$this->result = new stdclass();
	}		
	
	public function build() {
		$this->body->response = $this->result;
		return $this->body;
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
	
	public function addStandardCard($title, $text, $smallImage, $largeImage) {
		$card = new stdclass();
		
		$card->type = 'Standard';
		$card->title = $title;
		
		$card->text = $text;
		
		$card->image = $this::getImage($smallImage, $largeImage);
		
		$this->result->card = $card;
		
		return $this;
	}
	
	public function addShouldEndSession($endSession) {		
		$this->result->shouldEndSession = $endSession;
		
		return $this;
	}
	
	public function addSessionData($dataName, $data) {
		$this->body->sessionAttributes->$dataName = $data;
		
		return $this;
	}
	
	private function getImage($smallImage, $largeImage) {
		$result = new stdclass();
		$result->smallImageUrl = $smallImage;
		$result->largeImageUrl = $largeImage;
		
		return $result;
	}
}



















