var app = angular.module('PHPTester', []);

app.run(function ($templateCache) {
});

app.controller('PHPTesterController', ['$scope', '$http', '$templateCache', function($scope, $http, $templateCache) {
	// Some PHP error code constants
	var error_codes = {
		1: 'E_ERROR',
		2: 'E_WARNING',
		4: 'E_PARSE',
		8: 'E_NOTICE',
		16: 'E_CORE_ERROR',
		32: 'E_CORE_WARNING',
		64: 'E_COMPILE_ERROR',
		128: 'E_COMPILE_WARNING',
		256: 'E_USER_ERROR',
		512: 'E_USER_WARNING',
		1024: 'E_USER_NOTICE',
		2048: 'E_STRICT',
	},
	keysPressed = {};

	// Inital view state
	$scope.states = {
		hasError: false,
		loading: false,
	};

	$scope.runCode = function() {
		// Don't need to send an empty post
		if($scope.indata && $scope.indata.length > 0) {
			// Set some states for the view
			$scope.states.loading = true;
			$scope.states.hasError = false;

			// Send code off to php to taste
			$http.post('parser.php', {phpInput: $scope.indata})
				.success(function(data, status, headers, config) {
					$scope.states.loading = false;
					// Any PHP errors?
					if(data.phpError) {
						$scope.outdata = 'ERROR! Type: ' + error_codes[data.phpError.type] + '\n' + 'Message: ' + data.phpError.message;
						$scope.states.hasError = true;
					} else {
						$scope.outdata = data.phpOutput;
						$scope.executionTime = data.executionTime;
					}
				})
				.error(function(data, status, headers, config) {
					// Something went very wrong...but I don't care
					$scope.states.loading = false;
					$scope.outdata = 'This went very wrong. Is PHP running?'
				});
		}
	};

	$scope.prefillCode = function($event) {
		$event.preventDefault();
		// 'Loads' the content in the script template tag from index.php
		$scope.indata = $templateCache.get('code-1');
	}

	// Cmd + Enter
	$scope.keyDown = function($event) {
		if($event.keyCode === 13 && (keysPressed[91] || keysPressed[92] || keysPressed[93])) {
			$scope.runCode();
			keysPressed = {};
			return;
		}
		keysPressed[$event.keyCode] = $event.keyCode;
	}

	$scope.keyUp = function($event) {
		keysPressed = {};
	}
}]);