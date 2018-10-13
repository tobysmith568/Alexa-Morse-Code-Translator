<?php

include('../skill-ids.php');
include('intent-request.php');
include('morse-code.php');

$input = file_get_contents('php://input');
$post = json_decode($input);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	POST();
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT' && $_SERVER['HTTP_PUT_PASSWORD'] === PUT_PASSWORD) {
	PUT();
}
else {
	http_response_code(400);
    die();
}

///////////////////

function POST() {
	global $post, $input;
	
	date_default_timezone_set('UTC');

	$SignatureCertChainUrl = $_SERVER['HTTP_SIGNATURECERTCHAINURL'];

	if (MORSE_CODE_SKILL_ID == $post->session->application->applicationId AND $post->request->timestamp > date('Y-m-d\TH:i:s\Z', time()-150) AND preg_match('/https:\/\/s3\.amazonaws\.com(:433)?\/echo\.api\//', $SignatureCertChainUrl)) {
		$SignatureCertChainUrl_File = md5($SignatureCertChainUrl);
		$SignatureCertChainUrl_File = $SignatureCertChainUrl_File . '.pem';
		 
		if (!file_exists($SignatureCertChainUrl_File)) {
			file_put_contents($SignatureCertChainUrl_File, file_get_contents($SignatureCertChainUrl));
		}	

		$SignatureCertChainUrl_Content = file_get_contents($SignatureCertChainUrl_File);	
		$Signature_Content = $_SERVER['HTTP_SIGNATURE'];

		$SignatureCertChainUrl_Content_Array = openssl_x509_parse($SignatureCertChainUrl_Content);

		$Signature_PublicKey = openssl_pkey_get_public($SignatureCertChainUrl_Content);
		$Signature_PublicKey_Data = openssl_pkey_get_details($Signature_PublicKey);
		$Signature_Content_Decoded = base64_decode($Signature_Content);

		$Signature_Verify = openssl_verify($input, $Signature_Content_Decoded, $Signature_PublicKey_Data['key'], 'sha1');

		if (preg_match('/echo-api\.amazon\.com/', base64_decode($SignatureCertChainUrl_Content))
					AND $SignatureCertChainUrl_Content_Array['validTo_time_t'] > time()
					AND $SignatureCertChainUrl_Content_Array['validFrom_time_t'] < time()
					AND $Signature_Content
					AND $Signature_Verify == 1) {
			PUT();
		}
		else {
			http_response_code(400);
		}
	}
	else {
		http_response_code(400);
	}
}

function PUT() {
	global $post;
	header ('Content-Type: application/json');
	echo json_encode(runRequest($post->request), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

///////////////////

function runRequest($request) {	
	$result = new stdclass();
	
	$result->version = '1.0';
	
	switch ($request->type) {
		case 'LaunchRequest':
			$result->response = MorseCode::LaunchRequest($request);
			break;
		case 'IntentRequest':
			$result->response = MorseCode::IntentRequest($request);
			break;
	}
	
	return $result;
}

///////////////////

die();
















