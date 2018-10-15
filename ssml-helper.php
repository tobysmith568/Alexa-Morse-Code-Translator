<?php

if (str_replace('/', '\\', __FILE__) == str_replace('/', '\\', $_SERVER['SCRIPT_FILENAME'])) {
	http_response_code(400);
	die();
}

class SSML {
	
	public static function Speak($args) {
		$args = self::Stringify($args);
		return "<speak>$args</speak>";
	}
	
	public static function Audio($source) {
		return "<audio src=\"$source\"/>";
	}
	
	public static function HighRate($args) {
		$args = self::Stringify($args);
		return self::Prosody($args, 'rate="x-fast"');
	}
	
	public static function LowRate($args) {
		$args = self::Stringify($args);
		return self::Prosody($args, 'rate="x-slow"');
	}
	
	public static function HighPitched($args) {
		$args = self::Stringify($args);
		return self::Prosody($args, 'pitch="x-high"');
	}
	
	public static function LowPitched($args) {
		$args = self::Stringify($args);
		return self::Prosody($args, 'pitch="x-low"');
	}
	
	public static function HighVolume($args) {
		$args = self::Stringify($args);
		return self::Prosody($args, 'volume="x-loud"');
	}
	
	public static function LowVolume($args) {
		$args = self::Stringify($args);
		return self::Prosody($args, 'volume="silent"');
	}
	
	public static function Interjection($args) {
		$args = self::Stringify($args);
		return self::Prosody($args, 'interjection');
	}
	
	public static function Phoneme($sounds, $text) {
		return "<phoneme alphabet=\"ipa\" ph=\"$sounds\">$text</phoneme>";
	}
	
	private static function SayAs($string, $term, $format = null) {
		if ($format === null)
			return "<say-as interpret-as=\"$term\">$string</prosody>";
		
		return "<say-as interpret-as=\"$term\" format=\"$format\">$string</prosody>";		
	}
	
	private static function Prosody($string, $term) {
		return "<prosody $term>$string</prosody>";
	}
	
	private static function Stringify($args) {
		if (is_array($args))
			$args = implode('', $args);
		
		return $args;
	}
}



















