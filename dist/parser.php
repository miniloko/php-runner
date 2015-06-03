<?php
	$postData = file_get_contents('php://input');
	$postObj = json_decode($postData);
	$return = [];

	// Test loading indicator: usleep(500000); // 500000 = 500ms

	$returnWrap = '
	// Wrap user code in a function
	function runCode() {
		%s
	}

	// Buffer output generated in our function
	ob_start();
	runCode();
	$result = ob_get_contents();
	ob_end_clean();
	
	// Return to eval()
	return $result;
	';
	
	header('Content-Type: application/json');
	$timeStart = microtime(true);
	$return['phpOutput'] = eval(sprintf($returnWrap, $postObj->phpInput));
	$timeEnd = microtime(true);

	$error = error_get_last();
	if(is_array($error)) {
		ob_end_clean();
		$return['phpError'] = $error;
	}
	$return['executionTime'] = round(($timeEnd - $timeStart) * 1000, 4);
	echo json_encode($return, JSON_PRETTY_PRINT);
?>