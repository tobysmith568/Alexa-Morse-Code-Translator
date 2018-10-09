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
	
	public static $launchPhrases = [
		0 => 'What can I translate into Morse code for you?',
		1 => 'What would you like to translate?',
		2 => 'What shall I translate?',
		3 => 'What would you like translated?',
		4 => 'What would you like to know in Morse Code?',
		5 => 'What do you want translated?'
	];
	
	public static $launchTranslations = [
		0 => 'What is "pizza"?',
		1 => 'Tell me what "aeroplane" is in Morse code.',
		2 => 'Translate "school" into Morse code.',
		3 => 'Translate "what is your name?"',
		4 => 'What is "100" in Morse Code?',
		5 => 'Tell me what "hello" is.'
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
		$fullphrase = self::$launchPhrases[array_rand(self::$launchPhrases)];		
		$fullSSML = "<speak>$fullphrase</speak>";
		
		$content = self::$launchTranslations[array_rand(self::$launchTranslations)];	
		$fullContent = "eg, \"$content\"";
		
		return (new IntentRequestBuilder())
			->addSSML($fullSSML)
			->addSimpleCard($fullphrase, $fullContent)
			->addShouldEndSession(false)
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