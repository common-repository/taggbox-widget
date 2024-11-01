<?php
function ___taggbox_wp_api_call($apiUrl, $body, $header = NULL) {
    $header = (($header != NULL) ? $header : array());
    $args = ['body' => $body, 'timeout' => '5', 'redirection' => '5', 'httpversion' => '1.0', 'blocking' => true, 'headers' => $header, 'cookies' => []];
    $response = wp_remote_post($apiUrl, $args);
    $response = json_decode($response['body']);
    return $response;
}
function ___taggbox_exit_with_success($data = null) {
    echo json_encode(['status' => (bool)true, 'data' => (array)$data, 'message' => (string)'OK']);
    exit;
}
function ___taggbox_exit_with_danger($error = null) {
    echo json_encode(['status' => (bool)false, 'data' => (array)[], 'message' => (string)(($error != '') ? $error : 'Oh snap! Something went wrong.')]);
    exit;
}
function ___taggbox_d($data = 'NONE') {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
function ___taggbox_dd($data = 'NONE') {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die;
}
function ___taggbox_convert_object_to_array($data) {
    $data = json_encode($data);
    return json_decode($data, true);
}
function ___taggbox_input_sanitize($data) {
    $data = (string)$data;
    if (preg_match("/<[^>]*>/", $data))
	return ___taggbox_exit_with_danger("Special characters  are not allowed. Please remove them and try again.");
}
function ___tagbox__sanitize_request_data($___tagbox_requestInputData) {
    $___tagbox_inputReturnData = [];
    foreach ($___tagbox_requestInputData as $___tagbox_requestInputKey => $___tagbox_requestInput) :
	$___tagbox_inputReturnData[$___tagbox_requestInputKey] = sanitize_text_field($___tagbox_requestInput);
    endforeach;
    return $___tagbox_inputReturnData;
}
function ___taggbox_manage_api_response($response) {
    if (empty($response))
	return ___taggbox_exit_with_danger();
    $responseCode = $response->code;
    switch ($responseCode) :
	case 200:
	    return $response;
	    break;
	case 412:
	    return ___taggbox_exit_with_danger($response->message);
	    break;
	default:
	    if (!empty($response->message)) :
		return ___taggbox_exit_with_danger($response->message);
	    else :
		return ___taggbox_exit_with_danger($response->message);
	endif;
    endswitch;
}
