<?php
// display error in debugging
ini_set('display_errors', 1);

require_once 'connection.php';
$connector = new Connector();
$result = null;
if (!isset($_POST["list"])) { // fallback, if open the link directly without submitting a form
	$_POST["criterion"] = "b_rating";
	$_POST["order"] = "DESC";
}
// get the list of book
$result = $connector->select();

/**
 * Print all books in HTML
 * @param sql_resultset $result Result of book records in the db
 */
function printBooks($result) {
	$criterion = $order = ""; // user prompts about sorting criteria
	switch ($_POST["criterion"]) {
		case "b_author":
			$criterion = "author";
			break;
		case "b_rating":
			$criterion = "rating";
			break;
		case "b_date":
			$criterion = "time added";
			break;
		default:
			$criterion = "unknown criterion";
	}
	switch ($_POST["order"]) {
		case "ASC":
			$order = "ascend";
			break;
		case "DESC":
			$order = "descent";
			break;
	}
	if ($result->num_rows > 0) { // books exist
		echo "<p>The result is sorted by \"$criterion\" in $order order</p>";
		while($row = $result->fetch_assoc()) {
			echo "<div class='bookResult'>";
			echo "<p><span class='bookname'>" . $row["b_title"]. "</span> by " . $row["b_author"] . "<br>";
			echo "ID: " . $row["b_id"] . ", " . $row["b_rating"] . (($row["b_rating"]==1)?" point":" points") . ", added on " . $row["b_date"] . ", currently " . $row["b_status"] . ".";
			if (!empty($row["b_comment"])) {
				echo "<br>Comments: " . $row["b_comment"];
			}
			echo "</div>";
		}
	} else { // no books
		echo "<p>No books yet, do some reading :-)</p>";
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
	<h2>Book List</h2>
	<section>
		<?php 
		if (!empty($connector->getError())) { // db error check
			echo "<h3>Database Error</h3><p>" . $connector->getError() . "</p>";
		} else {
			printBooks($result);
		}
		?>
	</section>
	<section>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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
				<div class="inline">
					<input type="submit" value="Refresh" name="list">
				</div>
				<div class="inline">
					<input type="button" value="Add a new book" onclick="window.location='index.php';">
				</div>
			</div>
		</form>
	</section>
	</article>
</main>
<footer>
<p>Check out <a href="http://haoze.me" title="haoze.me" target="_blank">haoze.me</a> | follow me on <a href="https://de.linkedin.com/in/davidhaozezhang" title="Follow me on LinkedIn" target="_blank">LinkedIn</a> | License: <a href="https://opensource.org/licenses/MIT" title="MIT license" target="_blank">MIT</a></p>
</footer>
</body>
</html>
