<!DOCTYPE html>
<!--
Author: Haoze Zhang
Version: 27-10-2016
-->
<html>
<head>
<meta charset="utf-8">
<title>PHP student info</title>
</head>

<body>
<?php
/*
 * Internet programming exercise
 * Author: Haoze Zhang
 * Version: 27-10-2016
 */

// My info
echo "<h2>Student info<h2><pre>";
$info = array("Name" => "Haoze Zhang", "ID" => "274726", "Major" => "IT");
printStudent($info);

// Multidimensional array
$student1 = createStudent("Zhao Si", "123456", "ME");
$student2 = createStudent("Liu Neng", "123457", "CS");
$student3 = createStudent("Cui Hua", "123458", "EE");
$infos = array($student1, $student2, $student3);

// print array
foreach ($infos as $info) {
	printStudent($info);
}

// ten favourite words
$words[] = "forsake";
$words[] = "epitaph";
$words[] = "kin";
$words[] = "wrack";
$words[] = "fleet";
$words[] = "vagabond";
$words[] = "scrounge";
$words[] = "swagger";
$words[] = "resent";
$words[] = "airs";

// print words with letter "a"
echo "</pre><h2>These words contain letter \"a\" <h2><pre>";
foreach ($words as $word) {
	if (preg_match('/.*a.*/',$word)) {
		echo "$word <br>";
	}
}
echo "</pre>";

/*
 * print student info 
 */
function printStudent($info) {
	foreach ($info as $key => $value) {
		echo "$key: $value <br>";
	}
}

/*
 * create student array
 */
function createStudent($name, $id, $major) {
	return array("Name" => $name, "ID" => $id, "Major" => $major);
}
?>
</body>
</html>
