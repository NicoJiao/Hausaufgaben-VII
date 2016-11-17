<?php
ini_set('display_errors', 1);
session_start();
$w1Color = $w2Color = $w3Color = "";
$w1Error = $w2Error = $w3Error = "";
$w1Value = $w2Value = $w3Value = "";
$nameColor = $zipColor = $telColor = "";
$nameError = $zipError = $telError = "";
$nameValue = $zipValue = $telValue = "";
if (!isset($_SESSION['step']) || empty($_SESSION['step'])) {
	$_SESSION["step"] = 0;
}
if (isset($_POST["wish1"])) {
	$validated = true;
	$validated &= validateWish($_POST["wish1"], $w1Color, $w1Error, $w1Value);
	$validated &= validateWish($_POST["wish2"], $w2Color, $w2Error, $w2Value);
	$validated &= validateWish($_POST["wish3"], $w3Color, $w3Error, $w3Value);	
	if ($validated) {
		$_SESSION["wish1"] = normalize($_POST["wish1"]);
		$_SESSION["wish2"] = normalize($_POST["wish2"]);
		$_SESSION["wish3"] = normalize($_POST["wish3"]);
		$_SESSION["step"] = 1;
	}
} elseif (isset($_POST["name"])) {
	if (empty($_POST["name"])) {
		$nameColor = "style='color: red;'";
		$nameError = "Please leave your name";
	} elseif (!preg_match("/^(\w+\s?)+$/", $_POST["name"])) {
		$nameColor = "style='color: red;'";
		$nameError = "Please use only letters and spaces";
	} else {
		$nameValue = $_POST["name"];
	}
	if (empty($_POST["zip"])) {
		$zipColor = "style='color: red;'";
		$zipError = "We need your address to reach you";
	} elseif (!preg_match("/^[\w\s\d]+$/", $_POST["zip"])) {
		$zipColor = "style='color: red;'";
		$zipError = "Please use only digits, letters and space";
	} else {
		$zipValue = $_POST["zip"];
	}
	if (empty($_POST["tel"])) {
		$telColor = "style='color: red;'";
		$telError = "We need your telephone to contact you";
	} elseif (!preg_match("/^(\+)?(\d+[\s-]?)+$/", $_POST["tel"])) {
		$telColor = "style='color: red;'";
		$telError = "Phone number may start with + and have space and dash between numbers, nothing more";
	} else {
		$telValue = $_POST["tel"];
	}
	if (empty($nameError) && empty($zipError) && empty($telError)) {
		$_SESSION["name"] = normalize($_POST["name"]);
		$_SESSION["zip"] = normalize($_POST["zip"]);
		$_SESSION["tel"] = normalize($_POST["tel"]);
		$_SESSION["step"] = 2;
	}
}

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
		$value = $wish;
	}
	return $validated;
}

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
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<table>
		<tr><td class="leftC" <?php echo $w1Color ?>>1. Wish:</td><td><?php 
		
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
if ($_SESSION['step'] == 2) {
	session_destroy();
}
?>
</html>