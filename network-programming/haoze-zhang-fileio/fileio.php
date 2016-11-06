<!DOCTYPE html>
<!-- 
Exercise of internet programming
file io php
Author: Haoze Zhang
Version: 06-11-2016
 -->
<html>
<head>
<meta charset="utf-8">
<title>Rubbish file generator</title>
</head>
<body>
<h1>You have generated some rubbish on the server!</h1>
<?php
// global controlling variables
$ITERATIONS = 5;
$DEPTH = 5;

$_all_dirs = array();
$_file_number = 0;
$_directory_number = 0;

// isolate operation and make you safe
mkdir("isolated-dir");
chdir("isolated-dir");

echo "<h2>Start!</h2>";
for ($iteration = 0; $iterations < $GLOBALS["ITERATIONS"]; $iterations++) {
	echo "<h3>Log</h3>";
	generate_rubbish();
	echo "<p>Congratulations!</p>";
	echo "<p>You have made <strong>" . ($iterations + 1) . "</strong> iterations so far</p>";
	echo "<p>You have generated <strong>$_file_number</strong> rubbish files so far</p>";
	echo "<p>You have generated <strong>$_directory_number</strong> rubbish directories so far</p>";
	echo "<p>Delete the project folder to clean up :-)</p>";
	echo "<p>========================================================</p>";
}

/**
 * Main function to generate rubbish
 */
function generate_rubbish() {
	// return to original directory
	chdir(dirname(__FILE__) . "/isolated-dir");
 	generate_rubbish_directories($GLOBALS['DEPTH']);
	generate_rubbish_files();
	// clear dirs log after each iteration
	$GLOBALS["_all_dirs"] = array();
}

/**
 * generate multiple layers of directories on pwd
 * @param int $layer layers to be generated
 */
function generate_rubbish_directories($layer) {
	echo "<ul>";
	$currentLayerDirs[]= getcwd();
	global $_all_dirs;
	$_all_dirs[] = $currentLayerDirs;
	// every layer
	for($depth = 1; $depth < $layer; $depth++) {
		$nextLayerDirs = array();
		// every directory in the layer
		foreach ($currentLayerDirs as $pwd) {
			chdir($pwd);
			$createdDirs = make_dirs($depth + 1); // depth increses
			// log created dirs relative path
// 			$createdDirs = array_filter(glob('*'), 'is_dir');
			$absCreatedDirs = array();
			// convert to abs path
			foreach ($createdDirs as $subdir) {
				$absCreatedDirs[] = getcwd() . DIRECTORY_SEPARATOR .$subdir;
				echo "<li>creating: " . getcwd() . DIRECTORY_SEPARATOR . $subdir . "</li>";
			}
			$nextLayerDirs = array_merge($nextLayerDirs, $absCreatedDirs);
		}
		$currentLayerDirs = $nextLayerDirs;
		// log created dirs in global
		$_all_dirs[] = $currentLayerDirs;
	}
	echo "</ul>";
}

/**
 * make directory with random name
 * @param int $number number of directories
 * @return string[] name of directories
 */
function make_dirs($number) {
	$newDirs = array();
	for ($i = 0; $i < $number; $i++) {
		$newDir = str_shuffle(md5(time()));
		mkdir($newDir);
		$newDirs[] = $newDir;
		global $_directory_number;
		$_directory_number++;
	}
	return $newDirs;
}

/**
 * generate rubbish txt files with sub-directory information
 */
function generate_rubbish_files() {
	// each layer, reverse the record, start from the bottom layer
	foreach (array_reverse($GLOBALS["_all_dirs"]) as $layer) {
		// each dir
		foreach ($layer as $dir) {
			$rubbishWriter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir),
					RecursiveIteratorIterator::SELF_FIRST);
			$content = "";
			foreach($rubbishWriter as $name => $object){
				$content = $content . $name . "\n";
			}
			make_file($dir, $content);
		}
	}
}

/**
 * make 0-10 numbers of txt files contain certain content
 * @param handle $dir parent directory
 * @param string $content content to be writen to the file
 */
function make_file($dir, $content) {
	chdir($dir);
	for ($i = 0; $i < rand(0, 10); $i++) {
		$file = fopen(str_shuffle(md5(time())) . ".txt", "w");
		fwrite($file, $content);
		global $_file_number;
		$_file_number++;
	}
}

?>
</body>
</html>
