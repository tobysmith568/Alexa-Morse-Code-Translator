<?php

if (str_replace('/', '\\', __FILE__) == str_replace('/', '\\', $_SERVER['SCRIPT_FILENAME'])) {
	http_response_code(400);
	die();
}

class MorseCode {
	private static $characters = [
		'a' => '.-',
		'b' => '-...',
		'c' => '-.-.',
		'd' => '-..',
		'e' => '.',
		'f' => '..-.',
		'g' => '--.',
		'h' => '....',
		'i' => '..',
		'j' => '.---',
		'k' => '-.-',
		'l' => '.-..',
		'm' => '--',
		'n' => '-.',
		'o' => '---',
		'p' => '.--.',
		'q' => '--.-',
		'r' => '.-.',
		's' => '...',
		't' => '-',
		'u' => '..-',
		'v' => '...-',
		'w' => '.--',
		'x' => '-..-',
		'y' => '-.--',
		'z' => '--..',
		'0' => '-----',
		'1' => '.----',
		'2' => '..---',
		'3' => '...--',
		'4' => '....-',
		'5' => '.....',
		'6' => '-....',
		'7' => '--...',
		'8' => '---..',
		'9' => '----.'
	];
	
	public static function IntentRequest($request){
		$term = $request->intent->slots->term->value;
		
		$urlTerm = urlencode($term);
		$url = "https://api.tobysmith.uk/alexa/morse-code/get-message/?text=$urlTerm";
		$fullSSML = "<speak>In Morse Code, $term is: <audio src='$url' /></speak>";
		
		$fullCode = self::getMorseCode($term);
		
		$fullContent = "What is \"$term\" in Morse Code?";
		
		return (new IntentRequestBuilder())
			->addSSML($fullSSML)
			->addSimpleCard($fullContent, $fullCode)
			->build();
	}
	
	public static function LaunchRequest($request){
		
		$fullSSML = '<speak>What can I translate into Morse code for you?</speak>';
		$fullTitle = 'What can I translate into Morse code for you?';
		$fullContent = 'eg, "What is pizza?"';
		
		return (new IntentRequestBuilder())
			->addSSML($fullSSML)
			->addSimpleCard($fullTitle, $fullContent)
			->build();
	}
	
	private static function getMorseCode($term) {
		$result = '';
		$array = str_split($term);
		
		foreach ($array as $char) {
			if ($char === ' ')
				$result .= '    ';
			else
				$result .= (' ' . self::$characters[$char]);
		}
		
		return substr($result, 1);
	}
}