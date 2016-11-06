<!DOCTYPE html>
<!-- 
Exercise of internet programming
file io with recursive invoking php
Author: Haoze Zhang
Version: 06-11-2016
 -->
<html>
<head>
<meta charset="utf-8">
<title>Recursive rubbish file generator</title>
</head>
<body>
<h1>You have generated some rubbish RECURSIVELY on the server!</h1>
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
	echo "<ul>";
	make_subdirs(1);
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
 * Recursive invoking, make sub-directories in current directory and make sub-sub-dir in sub-dir...
 * @param current layer of recursion
 */
function make_subdirs($layer) {
	$createdDirs = make_dirs($layer + 1);
	generate_rubbish_file();

// 	$existingDirs = array_filter(glob('*'), 'is_dir');
// 	$absExistingDirs = array();
	// echo to the user
	$absCreatedDirs = array();
	foreach ($createdDirs as $subdir) {
		$absCreatedDirs[] = getcwd() . DIRECTORY_SEPARATOR .$subdir;
		echo "<li>creating: " . getcwd() . DIRECTORY_SEPARATOR . $subdir . "</li>";
	}
	// terminate if reaches desired depth
	if ($layer + 1 >= $GLOBALS["DEPTH"]) {
		foreach ($absCreatedDirs as $subdir) {
			chdir($subdir);
			generate_rubbish_file();
		}
		return;
	}
	// not terminated, keep recursive!
	foreach ($absCreatedDirs as $subdir) {
		chdir($subdir);
		make_subdirs($layer + 1);
	}
}

/**
 * generate rubbish file contain sub-directory information at pwd
 */
function generate_rubbish_file() {
	$rubbishWriter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(getcwd()),
				RecursiveIteratorIterator::SELF_FIRST);
		$content = "";
		foreach($rubbishWriter as $name => $object){
			$content = $content . $name . "\n";
		}
		make_file(getcwd(), $content);
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
