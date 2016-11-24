<!--
* index.php
* Version 1.0 20/11/2016
* @author Lijun.He
* Information about wishes
--> 
<?php 
	session_start();
	$_SESSION['views']= 1;
	// define variables and set to empty values
	$title = "";
	$wish1 = $wish2 = $wish3  = "";
	$wish1Err = $wish2Err = $wish3Err= "";
	$wish1color = $wish2color = $wish3color = "";
	$inputforwish1display = $inputforwish2display = $inputforwish3display = "";
	$spanforwish1display = $spanforwish2display = $spanforwish3display ="";
	$name = $zipandcity = $telephone = "";
	$nameErr = $zipandcityErr = $telephoneErr = "";
	$namecolor = $zipandcitycolor = $telephonecolor = "";
	$inputfornamedisplay = $inputforzipandcitydisplay = $inputfortelephonedisplay = "";
	$spanfornamedisplay = $spanforzipandcitydisplay = $spanfortelephonedisplay ="";
	$nameErrdisplay = $zipandcityErrdisplay = $telephoneErrdisplay = "";
	$lable4display = $lable5display = $lable6display = "";
	$cancle1 = $cancle2 = "";
	$ok1 = $ok2 = "";
	$patternforwish = '/^[^\d]+$/';
	$patternforname = '/^[a-zA-Z\s]+$/';
	$patternforzipandcity = '/^[\w\s]+$/';
	$patternfortelephone = '/\+?\d+/';
	
	
	if ($_SESSION['views'] == '1'){
			$inputforwish1display = "display:inline";
			$inputforwish2display = "display:inline";
			$inputforwish3display = "display:inline";
			$spanforwish1display = "display:none";
			$spanforwish2display = "display:none";
			$spanforwish3display = "display:none";
			$cancle1 = "display:inline";
			$ok1 = "display:inline";
			$inputfornamedisplay = "display:none";
			$inputforzipandcitydisplay = "display:none";
			$inputfortelephonedisplay = "display:none";
			$spanfornamedisplay = "display:none";
			$spanforzipandcitydisplay = "display:none";
			$spanfortelephonedisplay = "display:none";
			$lable4display = "display:none";
			$lable5display = "display:none";
			$lable6display = "display:none";
			$nameErrdisplay = "display:none";
			$zipandcityErrdisplay = "display:none";
			$telephoneErrdisplay = "display:none";
			$cancle2 = "display:none";
			$ok2 = "display:none";
	} 
	
	if(isset($_POST['submit1'])){
		if ($_SESSION['views'] == '1'){
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if (empty($_POST["wish1"])) {
					$wish1Err = "Please insert a wish!";
				} else if(preg_match($patternforwish,$_POST["wish1"]) == '1'){
					$wish1 = test_input($_POST["wish1"]) ;
					$wish1special = $wish1;
				} else {
					$wish1Err = "Please don't insert number in wish!";
				}
		
				if (empty($_POST["wish2"])) {
					$wish2Err = "Please insert a wish!";
				} else if (preg_match($patternforwish,$_POST["wish2"]) == '1'){
					$wish2 = test_input($_POST["wish2"]);
					$wish2special = $wish2;
				}else {
					$wish2Err = "Please don't insert number in wish!";
				}
		
				if (empty($_POST["wish3"])) {
					$wish3Err = "Please insert a wish!";
				} else if (preg_match($patternforwish,$_POST["wish3"]) == '1'){
					$wish3 = test_input($_POST["wish3"]);
					$wish3special = $wish3;
				} else {
					$wish3Err = "Please don't insert number in wish!";
				}
			}
		}
		
		if ($wish1Err === "" && $wish2Err === "" && $wish3Err === ""){
			$inputforwish1display = "display:none";
			$inputforwish2display = "display:none";
			$inputforwish3display = "display:none";
			$spanforwish1display = "display:inline";
			$spanforwish2display = "display:inline";
			$spanforwish3display = "display:inline";
			$cancle1 = "display:none";
			$ok1 = "display:none";
			$lable4display = "display:inline";
			$lable5display = "display:inline";
			$lable6display = "display:inline";
			$inputfornamedisplay = "display:inline";
			$inputforzipandcitydisplay = "display:inline";
			$inputfortelephonedisplay = "display:inline";
			$cancle2 = "display:inline";
			$ok2 = "display:inline";
			$_SESSION["wish1"] = $wish1;
			$_SESSION["wish2"] = $wish2;
			$_SESSION["wish3"] = $wish3;
			$_SESSION['views'] = 2;
		} else {
			if ($wish1Err != ""){
				$wish1color = "color:red";
			}
			if ($wish2Err != ""){
				$wish2color = "color:red";
			}
			if ($wish3Err != ""){
				$wish3color = "color:red";
			}
		}
	}

	if(isset($_POST['submit2'])){
		$wish1 = $_SESSION["wish1"];
		$wish2 = $_SESSION["wish2"];
		$wish3 = $_SESSION["wish3"];
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if (empty($_POST["name"])) {
					$nameErr = "Please insert your Name!";
				} else if(preg_match($patternforname,$_POST["name"]) == '1'){
					$name = test_input($_POST["name"]) ;
				} else {
					$nameErr = "Please insert letter and space in this field!";
				}
		
				if (empty($_POST["zipandcity"])) {
					$zipandcityErr = "Please insert ZIP and city!";
				} else if (preg_match($patternforzipandcity,$_POST["zipandcity"]) == '1'){
					$zipandcity = test_input($_POST["zipandcity"]);
				}else {
					$zipandcityErr = "Please insert number and letter and space in this field!";
				}
		
				if (empty($_POST["telephone"])) {
					$telephoneErr = "Please insert the Telephone number!";
				} else if (preg_match($patternfortelephone,$_POST["telephone"]) == '1'){
					$telephone = test_input($_POST["telephone"]);
				}else {
					$telephoneErr = "Please insert number in this field!";
				}
			}
			
		if ($nameErr === "" && $zipandcityErr === "" && $telephoneErr === ""){
			$spanforwish1display = "display:inline";
			$spanforwish2display = "display:inline";
			$spanforwish3display = "display:inline";
			$inputforwish1display = "display:none";
			$inputforwish2display = "display:none";
			$inputforwish3display = "display:none";
			$cancle1 = "display:none";
			$ok1 = "display:none";
			$lable4display = "display:inline";
			$lable5display = "display:inline";
			$lable6display = "display:inline";
			$inputfornamedisplay = "display:none";
			$inputforzipandcitydisplay = "display:none";
			$inputfortelephonedisplay = "display:none";
			$spanfornamedisplay = "display:inline";
			$spanforzipandcitydisplay = "display:inline";
			$spanfortelephonedisplay = "display:inline";
			$nameErrdisplay = "display:none";
			$zipandcityErrdisplay = "display:none";
			$telephoneErrdisplay = "display:none";
			$cancle2 = "display:none";
			$ok2 = "display:none";
			$_SESSION['views'] = 3;
		} else {
			$inputforwish1display = "display:none";
			$inputforwish2display = "display:none";
			$inputforwish3display = "display:none";
			$spanforwish1display = "display:inline";
			$spanforwish2display = "display:inline";
			$spanforwish3display = "display:inline";
			$cancle1 = "display:none";
			$ok1 = "display:none";
			$lable4display = "display:inline";
			$lable5display = "display:inline";
			$lable6display = "display:inline";
			$inputfornamedisplay = "display:inline";
			$inputforzipandcitydisplay = "display:inline";
			$inputfortelephonedisplay = "display:inline";
			$cancle2 = "display:inline";
			$ok2 = "display:inline";
			$nameErrdisplay = "display:inline";
			$zipandcityErrdisplay = "display:inline";
			$telephoneErrdisplay = "display:inline";
			$_SESSION['views'] = 2;
			if ($nameErr != ""){
				$namecolor = "color:red";
			}
			if ($zipandcityErr != ""){
				$zipandcitycolor = "color:red";
			}
			if ($telephoneErr != ""){
				$telephonecolor = "color:red";
			}
		}
	}

	
	switch ($_SESSION['views']){
		case '1':$title = "My Wishlist" ;
				break;
		case '2':$title = "Delivery information" ;
				break;
		case '3':$title = "Wishes overview" ;
				break;
	}
	
	
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>

<!DOCTYPE html>
<html lang = "en">
<!-- Language is English -->
<head>
<meta charset="UTF-8">
<title>Information about wishes</title>
<script type="text/javascript">
			function reset() {
				document.getElementById("lable1").style.color = "black";
			}
		</script>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
	<h2><?php echo $title?></h2><br>
	<form id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<div>
			<label id="lable1" style="<?php echo $wish1color?>">1.Wish:</label>
			<input type="text" name="wish1" size="20" maxlength="20" style="margin-left: 30px; <?php echo $inputforwish1display?>">
			<span id ="wish1display" style="margin-left: 30px; <?php echo $spanforwish1display?>" ><?php echo $wish1?></span>
			<span class="error" ><?php echo $wish1Err;?></span>
		</div>
		<br>
		<div>	
			<label id="lable2" style="<?php echo $wish2color?>">2.Wish:</label>
			<input type="text" name="wish2" size="20" maxlength="20" style="margin-left: 30px; <?php echo $inputforwish2display?>">
			<span id ="wish2display" style="margin-left: 30px; <?php echo $spanforwish2display?>" ><?php echo $wish2?></span>
			<span class="error"><?php echo $wish2Err;?></span>
		</div>
		<br>
		<div>
			<label id="lable3" style="<?php echo $wish3color?>">3.Wish:</label>
			<input type="text" name="wish3" size="20" maxlength="20" style="margin-left: 30px; <?php echo $inputforwish3display?>">
			<span id ="wish3display" style="margin-left: 30px; <?php echo $spanforwish3display?>" ><?php echo $wish3?></span>
			<span class="error"><?php echo $wish3Err;?></span>
		</div>
		<br>
		<div>
		<input type="button" value="Cancel" onclick="reset();" style="<?php echo $cancle1?>">
		<input type="submit" name="submit1" value="OK" style="<?php echo $ok1?>">
		
		</div>
	</form>
	<br>
	<form id="form2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<table>
			<tr>
				<td><label id="lable4" style="<?php echo $namecolor?>;<?php echo $lable4display?>">First and second <br>name:</label></td>
				<td><input type="text" name="name" size="20" maxlength="20" style="margin-left: 25px; <?php echo $inputfornamedisplay?>"></td>
				<td><span id ="namedisplay" style="margin-left: 30px; <?php echo $spanfornamedisplay?>" ><?php echo $name?></span></td>
				<td><span class="error" style="<?php echo $nameErrdisplay?>"><?php echo $nameErr;?></span></td>
			</tr>
			<tr>	
				<td><label id="lable5" style="<?php echo $zipandcitycolor?>;<?php echo $lable5display?>">ZIP and city</label></td>
				<td><input type="text" name="zipandcity" size="20" maxlength="20" style="margin-left: 25px; <?php echo $inputforzipandcitydisplay?>"></td>
				<td><span id ="zipandcitydisplay" style="margin-left: 30px; <?php echo $spanforzipandcitydisplay?>" ><?php echo $zipandcity?></span></td>
				<td><span class="error" style="<?php echo $zipandcityErrdisplay?>"><?php echo $zipandcityErr;?></span></td>
			</tr>
			<tr>
				<td><label id="lable6" style="<?php echo $telephonecolor?>;<?php echo $lable6display?>">Telephone</label></td>
				<td><input type="text" name="telephone" size="20" maxlength="20" style="margin-left: 25px; <?php echo $inputfortelephonedisplay?>"></td>
				<td><span id ="telephonedisplay" style="margin-left: 30px; <?php echo $spanfortelephonedisplay?>" ><?php echo $telephone?></span></td>
				<td><span class="error" style="<?php echo $telephoneErrdisplay?>"><?php echo $telephoneErr;?></span></td>
			</tr>
		</table>
		<div>
			<input type="reset" value="Cancel" style="<?php echo $cancle2?>">
			<input type="submit" name="submit2" value="OK" style="<?php echo $ok2?>">
		</div>
	</form>
</body>
</html>

