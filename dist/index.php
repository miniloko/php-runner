<!DOCTYPE html>
<html lang="en" ng-app="PHPTester">
<head>
	<meta charset="UTF-8">
	<title>PHP-tester</title>
	<link rel="stylesheet" href="style/style.css">
	<link href='http://fonts.googleapis.com/css?family=Share:400,700italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300,400' rel='stylesheet' type='text/css'>
	<script src="js/angularjs/angular.js"></script>
	<script src="js/phptester-app.js"></script>
</head>
<body ng-controller="PHPTesterController" class="viewport" ng-class="{'loading': states.loading}" ng-keydown="keyDown($event)" ng-keyup="keyUp($event)">
	<h1>eval('$php');</h1>
	<div class="app">
		<div class="indata">
			<textarea
				autofocus
				class="php-input"
				ng-model="indata"
				cols="30"
				rows="10"></textarea>
			<button
				class="button"
				ng-click="runCode()"
				ng-disabled="!indata || indata.length == 0">Run code</button> <em>or Cmd+Enter</em>
		</div>
		<div class="outdata">
			<small ng-show="executionTime">Execution time: {{executionTime}} milliseconds.</small><br>
			<pre class="php-output">&gt; <span>{{outdata}}</span><span class="pulsate">_</span></pre>
		</div>
		<a class="toggler"
			href="#"
			ng-click="prefillCode($event)">Prefill some code</a>
		<script type="text/ng-template" id="code-1">$arr = [];
$matches = [];
$iters = 1000;

for($i = 0; $i < $iters; $i++){
    $rnd = rand(0, $iters);
    if(isset($arr[$rnd])){
        $matches[$rnd] = isset($matches[$rnd]) ? $matches[$rnd] + 1 : 1;
    }
    $arr[] = $rnd;
}

function sorter($a,$b){
    if($a == $b) return 0;
    return ($a > $b) ? -1 : 1;
}

uasort($matches, 'sorter');

echo "Generated {$iters} numbers." . PHP_EOL . PHP_EOL . "Here are the 20 most recurring duplicates (value / number of duplicates): " . json_encode(array_slice($matches, 0, 20, true), JSON_PRETTY_PRINT) . PHP_EOL;
echo "Here is the complete set of generated numbers:" . PHP_EOL . json_encode($arr);</script>
	</div>
	<img src="logo.php.png" style="width: 0; height: 0;">
</body>
</html>