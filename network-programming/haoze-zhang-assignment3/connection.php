<?php
/**
 * Internet programming assignment: book management
 * Class Connetor, connects to mysql database
 * @author Haoze Zhang
 * @version 26-11-2016
 */
class Connector {
	var $connection = null;
	var $error = "";
	const host = "localhost";
	const uname = "root";
	const pw = "root";
	const dbname = "db_literatures";
	const sqlCheckDb = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'db_literatures'";
	const sqlCreateDb = "CREATE DATABASE db_literatures";
	const sqlCreateTable = "CREATE TABLE books (
	                        b_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	                        b_title VARCHAR(50) NOT NULL,
	                        b_author VARCHAR(50) NOT NULL,
	                        b_rating VARCHAR(5) NOT NULL,
	                        b_status VARCHAR(10) NOT NULL,
	                        b_comment VARCHAR(1000),
	                        b_date TIMESTAMP
	                        )";
	const sqlInsert = "INSERT INTO books (b_title, b_author, b_rating, b_status, b_comment) 
	                   VAlUES (?, ?, ?, ?, ?)";
	const sqlSelect = "SELECT b_id, b_title, b_author, b_status, b_rating, b_comment, b_date 
	                   FROM books
	                   ORDER BY";
	
	function __construct() {
		// nothing
	}

	/**
	 * Connect to the db, create a new one if not exists
	 */
	private function connect() {
		$this->connection = new mysqli(self::host, self::uname, self::pw);
		if ($this->connection->connect_error) { // cannot connect
			$this->error .= "#Connection " . $this->connection->connect_error;
		}
		if ($this->connection->query(self::sqlCheckDb)->num_rows == 0) { // db not exsits
			if ($this->connection->query(self::sqlCreateDb) == false) { // create db
				$this->error .= "#CreateDB " . $this->connection->error . "<br>";
			} else { // connect to db
				$this->connection = new mysqli(self::host, self::uname, self::pw, self::dbname);
				if ($this->connection->query(self::sqlCreateTable) == false) { // create table
					$this->error .= "#CreateTable " . $this->connection->error . "<br>";
				}
			}
		} else { // db exists, connect
			$this->connection = new mysqli(self::host, self::uname, self::pw, self::dbname);
		}
	}

	/**
	 * Disconnect database
	 */
	private function disconnect() {
		$this->connection->close();
	}

	/**
	 * Execute insert query to insert a new book record to the db
	 */
	function insert() {
		$this->connect();
		// treat against XSS
		$title = $this->normalize($_POST["title"]);
		$author = $this->normalize($_POST["author"]);
		$rating = $this->normalize($_POST["rating"]);
		$status = $this->normalize($_POST["status"]);
		$comment = $this->normalize($_POST["comment"]);
		if ($preparedStatement = $this->connection->prepare(self::sqlInsert)) {
			$preparedStatement->bind_param("sssss", $title, $author, $rating, $status, $comment);
			if(!$preparedStatement->execute()) {
				$this->error .= "#ExecuteInsert " . $this->connection->error . "<br>";
			}
		} else {
			$this->error .= "#PrepareInsert " . $this->connection->error . "<br>";
		}
		$this->disconnect();
	}
	
	/**
	 * Execute select query and list all book in desired order
	 * @return result set of the query, return null if failed
	 */
	function select() {
		$result = null;
		$this->connect();
		if ($preparedStatement = $this->connection->prepare(self::sqlSelect . " " . $_POST["criterion"] . " " . $_POST["order"])) {
			if(!$preparedStatement->execute()) {
				$this->error .= "#ExecuteSelect " . $this->connection->error . "<br>";
			}
			$result = $preparedStatement->get_result();
			if (!$result) {
				$this->error .= "#GetResultSelect " . $this->connection->error . "<br>";
			}
		} else {
			$this->error .= "#PrepareSelect " . $this->connection->error . "<br>";
		}
		$this->disconnect();
		return $result;
	}

	/**
	 * Getter of connection error messages
	 * @return string Error message of connection
	 */
	function getError() {
		return $this->error;
	}

	/**
	 * normalize data to prevent XSS
	 * @param original user input
	 * @return normalized data
	 */
	function normalize($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}
?>
