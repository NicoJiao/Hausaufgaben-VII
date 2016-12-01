<?php
// display error in debugging
ini_set('display_errors', 1);

require_once 'connection.php';
$connector = new Connector();
// error related variables
$error = "";
$titleError = $authorError = "";
if (isset($_POST["submit"])) { // insert book into db if submitted
	if (validate($error, $titleError, $authorError)) { // validate input
		$connector->insert();
	}
}

/**
 * Validate form inputs
 * @param string $error general error message
 * @param string $titleError title style, red if error
 * @param string $authorError author style, red if error
 * @return boolean true if valid, false if error
 */
function validate(&$error, &$titleError, &$authorError) {
	if (empty($_POST["title"])) { // title cannot be empty
		$error .= "Title of the book is required.<br>";
		$titleError = "color: red;";
	} elseif (preg_match("/[<><>\/\\`~]/", $_POST["title"])) { // title contains no special chars
		$error .= "Please do not use special characters (e.g. <>/\`~) for book title.<br>";
		$titleError = "color: red;";
	}
	if (empty($_POST["author"])) { // author cannot be empty
		$error .= "Author is required<br>";
		$authorError = "color: red;";
	} else {
		if (preg_match("/[<>\/\\`~<>]/", $_POST["author"])) { // other validations
			$error .= "Please do not use special characters (e.g. <>/\`~) for author name.<br>";
			$authorError = "color: red;";
		} if (preg_match("/[0-9]/", $_POST["author"])) {
			$error .= "Please do not use numbers for author name<br>";
			$authorError = "color: red;";
		} if (!preg_match("/^.+ .+/", $_POST["author"])) {
			$error .= "Author name has to contain at least a first and last name, separated by a space. E.g. Sheraz Azad.<br>";
			$authorError = "color: red;";
		} if (!preg_match("/^[A-Z].*( [A-Z].*)+$/", $_POST["author"])) {
			$error .= "Every part of the author name should start with a leading capital letter. E.g. Sheraz Azad.<br>";
			$authorError = "color: red;";
		}
	}
	if (empty($error)) {
		return true;
	} else {
		return false;
	}
}
?>

<!DOCTYPE HTML>
<!-- 
	Internet Programming Assignment 3: Book management
	Author: Haoze Zhang
	Version: 24-11-2016
-->
<html lang="en">
<head>
<meta charset="utf-8">
<title>Book management</title>
<link href="_css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
  <h1>Internet Programming Assignment</h1>
</header>
<main>
  <article>
	<h2>Book management</h2>
    <section>
    	<?php 
    	if (!isset($_POST["submit"])) {
    		echo "<h3>Welcome</h3><p>Welcome to the book management system. You can upload your books into the system, and check all of the books at a glance.</p>";
    	} elseif (!empty($connector->getError())) {
    		echo "<h3>Database Error</h3><p>Error message: <br>".$connector->getError()."</p>";
    	} elseif (!empty($error)) {
    		echo "<h3>Book NOT added</h3><p>$error</p>";
    	} else {
    		echo '<h3>Book added</h3><p>You have successfully added the book <span class="bookname">'.$_POST['title']."</span> written by ".$_POST['author'].".</p>";
    	}
    	?>
    	<h3>Submit your book</h3>
    	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    	<div class="section">
    		<div class="inline"><span class="cap" style="<?php echo $titleError?>">Title:</span>
    		<input type="text" name="title" id="title" value="<?php if (!empty($error)) echo $_POST["title"]?>"></div>
    		<div class="inline"><span class="cap" style="<?php echo $authorError?>">Author:</span>
    		<input type="text" name="author" id="author" value="<?php if (!empty($error)) echo $_POST["author"]?>"></div>
    		<div class="inline">
    			<span class="cap">Rating:</span>
	    		<select name="rating" >
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5" selected>5</option>
				</select>
			</div>
			<div class="inline">
	    		<span class="cap">Status:</span>
	    		<select name="status">
	    			<option value="bought" selected>Bought</option>
	    			<option value="reading">Reading</option>
	    			<option value="finished">Finished</option>
	    		</select>
    		</div>
    	</div>
    	<div class="section">
    		<span class="cap">Comments: (optional)</span>
    		<textarea rows="10" cols="100" placeholder="Write your comments here." name="comment" id="comment" style="display: block;"></textarea>
    	</div>
		<script src="_js/validate.js" type="text/javascript"></script>
		<input type="submit" value="Submit my book" name="submit">
    	</form>
	</section>
	<section>
		<h3>Check all books</h3>
		<p>We will list all books in record to you, and sort them as your wish.</p>
		<form action="list.php" method="post">
			<div class="section">
				<div class="inline">
					<span class="cap">Sort criterion:</span>
					<select name="criterion">
						<option value="b_author">Author</option>
						<option value="b_rating" selected>Rating</option>
						<option value="b_date">Time added</option>
					</select>
				</div>
				<div class="inline">
					<span class="cap">Order:</span>
					<select name="order">
						<option value="ASC">Ascent</option>
						<option value="DESC" selected>Descent</option>
					</select>
				</div>
			</div>
			<input type="submit" value="List all books" name="list" style="display: block;">
		</form>
	</section>
  </article>
</main>
<footer>
	<p>Check out <a href="http://haoze.me" title="haoze.me" target="_blank">haoze.me</a> | follow me on <a href="https://de.linkedin.com/in/davidhaozezhang" title="Follow me on LinkedIn" target="_blank">LinkedIn</a> | License: <a href="https://opensource.org/licenses/MIT" title="MIT license" target="_blank">MIT</a></p>
</footer>
</body>
</html>
