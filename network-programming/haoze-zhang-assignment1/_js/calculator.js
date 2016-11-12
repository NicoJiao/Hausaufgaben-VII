/*
Internet progamming, free fall calculator
Author: Haoze Zhang
Version: 09-11-2016
*/

function calculate(paraType, para, G, tv, v0) {
	var impossible = false;
	var h = 0;
	var t = 0;
	var v = 0;
	var tt = -1; // terminal time
	
	/* Impossible drops:
	 * Absolute initial velocity larger than terminal velocity
	 * Final velocity larger than terminal velocity
	 */
	if (tv > 0 && Math.abs(v0) > tv) {
		impossible = true;
	}
	
	/* Do the real calculations here
	 * If you don't understand, please retake high school physics
	 */
	switch (paraType) {
		case "h":
			h = para;
			v = Math.sqrt(2*G*h + Math.pow(v0,2));
			if (tv > 0 && v > tv) { // reach terminal
				v = tv;
				tt = (tv - v0) / G;
				t = tt + (h - (Math.pow(v,2) - Math.pow(v0,2)) / (2 * G)) / tv;
			} else {
				t = (v - v0) / G;
			} break;
		case "t":
			t = para;
			v = v0 + G * t;
			if (tv > 0 && v > tv) { // reach terminal
				v = tv;
				tt = (tv - v0) / G;
				h = (Math.pow(tv,2) - Math.pow(v0,2)) / (2 * G);
				h += (t - tt) * tv;
			} else {
				h = v0 * t + 0.5 * G * Math.pow(t, 2);
			} break;
		case "v":
			v = para;
			if (tv > 0 && para < tv) {
				impossible = true;
			} else {
				h = (Math.pow(v,2) - Math.pow(v0,2)) / (2 * G);
				t = (v - v0) / G;
			}
			break;
		default: return;
	}
	window.location = 'result.htm?i=' + impossible + "&h=" + h + "&t=" + t + "&v=" + v + "&tt=" + tt;
}

/**
 * Validate a certain input field
 * @param key ID for the input field
 * @return Error message, empty if correct
 */
function validateText(key) {
	var rules = {};
	rules["para"] = /^(?:\d*\.)?\d+$/; // positive number
	rules["G"] = /^(?:\d*\.)?\d+$/; // positive number
	rules["tv"] = /^(?:\d*\.)?\d+$/; // positive number
	rules["iv"] = /^-?(?:\d*\.)?\d+$/; // number
	
	var param = document.getElementById("parameters");
	// error prompt for each field
	var errors= {};
	errors["para"] = "Parameter " + param.options[param.selectedIndex].text + " must be a possitive number;\n";
	errors["G"] = "Gravitational acceleration must be a positive number;\n";
	errors["tv"] = "Terminal velocity must be a positive number;\n";
	errors["iv"] = "Initial velocity must be a number;\n";
	
	// Reture error message or nothing
	if (!rules[key].test(document.getElementById(key).value)) {
		return errors[key];
	} else
		return "";
}

/**
 * Validate input fields and calculate
 */
function validate() {
	var paraType = "";
	var para = 0;
	var G = 9.8;
	var tv = -1;
	var v0 = 0;
	var error = "";
	
	var parameter = document.getElementById("parameters");
	paraType = parameter[parameter.selectedIndex].value;
	para = document.getElementById("para").value;
	
	// Parameter must be a number, cannot be empty
	if (document.getElementById("para").value !== "") {
		error += validateText("para");
	} else {
		error += "Parameter " + parameter.options[parameter.selectedIndex].text + " cannot left blank;\n";
	}
	
	// G must be possitive
	if (document.getElementById("G-chk").checked) {
		if (document.getElementById("G").value !== "") {
			if (document.getElementById("G").value == 0) {
				error += "G cannot be zero;/n";
			} else {
				error += validateText("G");
				G = document.getElementById("G").value;
			}
			
		}
	}
	
	// Teminal velocity must be possitive
	if (document.getElementById("tv-chk").checked) {
		if (document.getElementById("tv").value !== "") {
			if (document.getElementById("tv").value == 0) {
				error += "Terminal velocity cannot be zero;/n";
			} else {
				error += validateText("tv");
				tv = document.getElementById("tv").value;
			}
		} else {
			tv = 53;
		}
	}
	
	// Initial velocity must be a number
	if (document.getElementById("iv-chk").checked) {
		if (document.getElementById("iv").value !== "") {
			error += validateText("iv");
			v0 = document.getElementById("iv").value;
		}
	}
	
	// Calculate or prompt
    if (error === "") {
		calculate(paraType, para, G, tv, v0);
		return;
	} else {
		alert("Please double check the following fields:\n" + error.substring(0, error.length-2) + ".");
	}
}

/**
 * Change the unit of input refer to the parameter seletion
 */
function changeUnit() {
	var param = document.getElementById("parameters");
	switch (param.options[param.selectedIndex].value) {
		case "h":
			document.getElementById("unit").innerHTML=" m";
			break;
		case "t":
			document.getElementById("unit").innerHTML=" s";
			break;
		case "v":
			document.getElementById("unit").innerHTML=" m/s";
			break;
	}	
}

/**
 * Show details when option checkbox is checked
 */
function showOptions() {
	var options = [];
	options.push(document.getElementById("G-chk"));
	options.push(document.getElementById("tv-chk"));
	options.push(document.getElementById("iv-chk"));
	var divs =[];
	divs.push(document.getElementById("G-div"));
	divs.push(document.getElementById("tv-div"));
	divs.push(document.getElementById("iv-div"));
	for (var i = 0; i < options.length; i++) {
		if (options[i].checked) {
			divs[i].style.display = "block";
		} else {
			divs[i].style.display = "none";
		}
	}
}

/**
 * Update parameter unit and non-displayed fields
 */
document.addEventListener('DOMContentLoaded', function() {
	showOptions();
	changeUnit();
}, false);
