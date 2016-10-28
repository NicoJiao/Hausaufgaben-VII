/*
 * Haoze Zhang 28-10-2016
*/

// return name attribute if text value doesn't match regex
function validateText(text, regex) {
	if (!regex.test(text.value)) {
		return text.name + ": " + text.placeholder;
	} else
		return "";
}

// validate each field
function validate() {
	// regex rules for each field
	var rules = [
		/.+/,
		/^[A-Z].*/,
		/^(?:\d*\.)?\d+$/,
		/^[0-9]{1}[.][0-9]{2}$/,
		/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
		/^(?=.*[a-zA-Z]).{2,8}$/];
	var errors = "";
	var fields = document.getElementById("fields").getElementsByTagName("input");
	// check each field
	for (var i = 0; i < fields.length; i++) {
		var error = validateText(fields[i], rules[i]);
    	if (error !== "") {
			errors += (error + ",\n");
		}
	}
	// prompt user the result
	if (errors === "") {
		alert("Your form is well formed!");
	} else {
		alert("Please double check the following fields:\n" + errors.substring(0, errors.length-2) + ".");
	}
}