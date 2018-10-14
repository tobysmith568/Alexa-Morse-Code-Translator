<?php

if (str_replace('/', '\\', __FILE__) == str_replace('/', '\\', $_SERVER['SCRIPT_FILENAME'])) {
	http_response_code(400);
	die();
}

class SSML {
	
	public function __construct() {
	}
	
	public function Speak($args) {
		$args = self::Stringify($args);
		return "<speak>$args</speak>";
	}
	
	public function Audio($source) {
		return "<audio src=\"$source\"/>";
	}
	
	public function HighRate($args) {
		$args = self::Stringify($args);
		return Prosody($args, 'rate="x-fast"');
	}
	
	public function LowRate($args) {
		$args = self::Stringify($args);
		return Prosody($args, 'rate="x-slow"');
	}
	
	public function HighPitched($args) {
		$args = self::Stringify($args);
		return Prosody($args, 'pitch="x-high"');
	}
	
	public function LowPitched($args) {
		$args = self::Stringify($args);
		return Prosody($args, 'pitch="x-low"');
	}
	
	public function HighVolume($args) {
		$args = self::Stringify($args);
		return Prosody($args, 'volume="x-loud"');
	}
	
	public function LowVolume($args) {
		$args = self::Stringify($args);
		return Prosody($args, 'volume="silent"');
	}
	
	public function Interjection($args) {
		$args = self::Stringify($args);
		return Prosody($args, 'interjection');
	}
	
	private function SayAs($string, $term, $format = null) {
		if ($format === null) {
			return "<say-as interpret-as=\"$term\">$string</prosody>";
		
		return "<say-as interpret-as=\"$term\" format=\"$format\">$string</prosody>";		
	}
	
	private function Prosody($string, $term) {
		return "<prosody $term>$string</prosody>";
	}
	
	private function Stringify($args) {
		if (is_array($args))
			$args = implode('', $args);
		
		return $args;
	}
}



















