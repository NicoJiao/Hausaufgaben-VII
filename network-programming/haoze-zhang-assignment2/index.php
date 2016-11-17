<?php
/*
 * Internet programming assignment 2
 * Author: Haoze Zhang
 * Version: 17-11-2016
 */
// use session
session_start();
// display error in debugging
ini_set('display_errors', 1);
// variables required to insert into http
$w1Color = $w2Color = $w3Color = "";
$w1Error = $w2Error = $w3Error = "";
$w1Value = $w2Value = $w3Value = "";
$nameColor = $zipColor = $telColor = "";
$nameError = $zipError = $telError = "";
$nameValue = $zipValue = $telValue = "";
// set step variable to identify page
if (!isset($_SESSION['step']) || empty($_SESSION['step'])) {
	$_SESSION["step"] = 0;
}
// check which form is being sent
if (isset($_POST["wish1"])) { // page1 form
	// validate inputs and save them as session variables
	// if not valid, color corresponding td to red and prompt user error messages
	$validated = true;
	$validated &= validateWish($_POST["wish1"], $w1Color, $w1Error, $w1Value);
	$validated &= validateWish($_POST["wish2"], $w2Color, $w2Error, $w2Value);
	$validated &= validateWish($_POST["wish3"], $w3Color, $w3Error, $w3Value);	
	if ($validated) {
		$_SESSION["wish1"] = normalize($_POST["wish1"]);
		$_SESSION["wish2"] = normalize($_POST["wish2"]);
		$_SESSION["wish3"] = normalize($_POST["wish3"]);
		$_SESSION["step"] = 1; // display the next page (1)
	}
} elseif (isset($_POST["name"])) { // page2 form
 	// validate inputs and save them as session variables
 	// if not valid, color corresponding td to red and prompt user error messages
	if (empty($_POST["name"])) { // name cannot be empty
		$nameColor = "style='color: red;'";
		$nameError = "Please leave your name";
	} elseif (!preg_match("/^(\w+\s?)+$/", $_POST["name"])) { // name not preg match
		$nameColor = "style='color: red;'";
		$nameError = "Please use only letters and spaces";
	} else { // name valid!
		$nameValue = $_POST["name"];
	}
	if (empty($_POST["zip"])) { // zip empty
		$zipColor = "style='color: red;'";
		$zipError = "We need your address to reach you";
	} elseif (!preg_match("/^[\w\s\d]+$/", $_POST["zip"])) { // zip not preg match
		$zipColor = "style='color: red;'";
		$zipError = "Please use only digits, letters and space";
	} else { // zip valid!
		$zipValue = $_POST["zip"];
	}
	if (empty($_POST["tel"])) { // tel empty
		$telColor = "style='color: red;'";
		$telError = "We need your telephone to contact you";
	} elseif (!preg_match("/^(\+)?(\d+[\s-]?)+$/", $_POST["tel"])) { // tel not preg match
		$telColor = "style='color: red;'";
		$telError = "Phone number may start with + and have space and dash between numbers, nothing more";
	} else { // tel valid!
		$telValue = $_POST["tel"];
	}
	if (empty($nameError) && empty($zipError) && empty($telError)) { // save form2 inputs as session variables
		$_SESSION["name"] = normalize($_POST["name"]);
		$_SESSION["zip"] = normalize($_POST["zip"]);
		$_SESSION["tel"] = normalize($_POST["tel"]);
		$_SESSION["step"] = 2;
	}
}
/*
 * validate wishes, cannot be empty and cannot contain digits
 * $wish: the wish to validate
 * &$color: css style in html
 * &$error: error message prompt in html
 * &$value: value saved in session
 * return: boolean validated: true; not valid: false
 */
function validateWish($wish, &$color, &$error, &$value) {
	$validated = true;
	if (empty($wish)) {
		$color = "style='color: red;'";
		$error = "Make a wish!";
		$validated = false;
	} elseif (preg_match("/.*\d.*/", $wish)){
		$color = "style='color: red;'";
		$error = "Please don't use numbers in a wish";
		$validated = false;
	} else {
		$value = normalize($wish);
	}
	return $validated;
}
/*
 * normalize data to prevent XSS
 */
function normalize($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP form</title>
	<meta charset="utf-8">
	<link href="_css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header><h1>Internet Programming Assignment</h1></header>
<main>
<article>
	<h2><?php
	// Different titles for each 3 pages
	switch($_SESSION["step"]) {
		case 0:
			echo "My Wish List";
			break;
		case 1:
			echo "Delivery Information";
			break;
		default:
			echo "Wishes Overview";
			break;
	}
?></h2>
	<section>
	<!-- form is sent back to the same script via POST method  -->
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<table>
		<tr><td class="leftC" <?php echo $w1Color ?>>1. Wish:</td><td><?php 
		// Table 1 display as input in page 0, as content in other pages
		switch($_SESSION["step"]) {
			case 0:
				echo "<input name='wish1' type='text' value='$w1Value'><td><span class='error'>$w1Error</span></td>";
				break;
			default:
				echo $_SESSION["wish1"];
				break;
		}
		?></td></tr>
		<tr><td class="leftC" <?php echo $w2Color ?>>2. Wish:</td><td><?php
		switch($_SESSION["step"]) {
			case 0:
				echo "<input name='wish2' type='text' value='$w2Value'><td><span class='error'>$w2Error</span></td>";
				break;
			default:
				echo $_SESSION["wish2"];
				break;
		}
		?></td></tr>
		<tr><td class="leftC" <?php echo $w3Color ?>>3. Wish:</td><td><?php
		switch($_SESSION["step"]) {
			case 0:
				echo "<input name='wish3' type='text' value='$w3Value'><td><span class='error'>$w3Error</span></td>";
				break;
			default:
				echo $_SESSION["wish3"];
				break;
		}
		?></td></tr>
		</table>
		<table style="display: <?php 
		// The second table which contains contact information is hidden in page 0
		switch($_SESSION["step"]) {
			case 0:
				echo "none";
				break;
			default:
				echo "block";
				break;
		}
		?>;">
		<tr><td class="leftC" <?php echo $nameColor ?>>First and second name:</td><td><?php
		switch($_SESSION["step"]) {
			case 1:
				echo "<input name='name' type='text' value='$nameValue'><td><span class='error'>$nameError</span></td>";
				break;
			default:
				echo $_SESSION["name"];
				break;
		}
		?></td></tr>
		<tr><td class="leftC" <?php echo $zipColor ?>>ZIP and city:</td><td><?php
		switch($_SESSION["step"]) {
			case 1:
				echo "<input name='zip' type='text' value='$zipValue'><td><span class='error'>$zipError</span></td>";
				break;
			default:
				echo $_SESSION["zip"];
				break;
		}
		?></td></tr>
		<tr><td class="leftC" <?php echo $telColor ?>>Telephone:</td><td><?php
		switch($_SESSION["step"]) {
			case 1:
				echo "<input name='tel' type='text' value='$telValue'><td><span class='error'>$telError</span></td>";
				break;
			default:
				echo $_SESSION["tel"];
				break;
		}
		?></td></tr>
		</table>
		<!-- Cancel button refreshes the page without transmiting a form -->
		<input type="button" value="Cancel" onclick="window.location='index.php'">
		<input type="submit" value="OK">
	</form>
	</section>
</article>
</main>
	
<footer>
	<p>Check out <a href="http://haoze.me" title="haoze.me" target="_blank">haoze.me</a> | follow me on <a href="https://de.linkedin.com/in/davidhaozezhang" title="Follow me on LinkedIn" target="_blank">LinkedIn</a> | License: <a href="https://opensource.org/licenses/MIT" title="MIT license" target="_blank">MIT</a></p>
</footer>
</body>
<?php
// The session variables are destroyed after the last page is generated
// if enables user to make another wish list
if ($_SESSION['step'] == 2) {
	session_destroy();
}
?>
</html>