/*
 * Validate inputs not to be empty and contain no special characters
 */
function validate() {
	var rule = /^[^<>\\/]+$/; // no XSS characters
	var ids = ["title", "author"];
	var error = "";
	
	for (var i = 0; i < ids.length; i++) {
		var input = document.getElementById(ids[i]);
		if (input.value == "") {
			error += "Please fill in the " + ids[i] + " field;\n"
		} else if (!rule.test(input.value)) {
			error += "Please do not use special characters in the " + ids[i] + " field;\n";
		}
	}
	if (error === "") {
		return true;
	} else {
		alert(error.substring(0, error.length-2) + ".");
		return false;
	}
}