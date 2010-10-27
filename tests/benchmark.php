<?php

require_once '../lib/pChart.php';

$startTime = microtime(true);

$numTests = 5;
for ($i = 1; $i <= $numTests; $i++) {
	$localStart = microtime(true);
	print "Processing example $i ...";
	include "../examples/Example$i.php";
	print "done, took ".round(microtime(true) - $localStart, 1)." seconds\n";
}

$endTime = microtime(true);
print "Overall took ".round($endTime - $startTime, 1)." seconds\n";
print "On average ".round(($endTime - $startTime) / $numTests, 1)." seconds per chart\n";