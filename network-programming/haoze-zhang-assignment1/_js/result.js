/*
Internet progamming, free fall calculator
Author: Haoze Zhang
Version: 12-11-2016
*/

/**
 * get parameters from URL
 */
function getParas () {
	var paras = {};
	var paraString = window.location.search.substring(1);
	var entrances = paraString.split("&");
	for (var i = 0; i < entrances.length; i++) {
		var pair = entrances[i].split("=");
		paras[pair[0]] = decodeURIComponent(pair[1]);
	}
	return paras;
}

/**
 * fill in the paragraph with proper wording and numbers
 */
function fillInResult(paras) {
	var resultP = document.getElementById("result");
	// impossible falls
	if (paras["i"] == "true") {
		resultP.innerHTML = "You know what, I am embarrassed. Because it is an impossible fall. Please go back and check the input, perhaps either the initial velocity or the final speed is larger than the  velocity. It cannot be like this, I hope you understand."
		return;
	}
	// 0 height fall
	if (paras["h"] == 0) {
		resultP.innerHTML = "Yeah, being on the ground is the safest option. But would you like to have some fun?"
		return;
	}
	// non-terminal falls
	if (paras["tt"] < 0) {
		resultP.innerHTML = "Wow! The fall was " + paras["h"] + " meters tall and it reached the final speed of " + paras["v"] + " meters per second (" + (paras["v"]*3.6) + " km/h) "+ "in just " + paras["t"] + " seconds!"
	} else { // terminal falls
		resultP.innerHTML = "So fast! The fall was " + paras["h"] + " meters tall and it reached the terminal speed of " + paras["v"] + " (" + (paras["v"]*3.6) + "km/h)" + " meters per second in just " + paras["tt"] + " seconds and took another " + (paras["t"] - paras["tt"]) + " seconds to touch the ground";
	}
}

/**
 * fill in the picture and title
 * @param paras parameters extracted from the URL
 */
function fillInContent(paras) {
	var img = document.getElementById("img");
	var fallType = document.getElementById("fallType");
	if (paras["i"] == "true") {
		img.src = "_images/impossible.png"
		fallType.innerHTML = "an impossible";
		fillInResult(paras);
		return;
	}
	var h = paras["h"];
	if (h == 0) {
		fallType.innerHTML = "a very very boring";
		img.src = "_images/smile.png";
	} else if (h < 5) {
		fallType.innerHTML = "a basketball";
		img.src = "_images/basketball.png"
	} else if (h < 50) {
		fallType.innerHTML = "a superman";
		img.src = "_images/superman.png"
	} else if (h < 500) {
		fallType.innerHTML = "a tower";
		img.src = "_images/tower.png"
	} else if (h < 5000) {
		fallType.innerHTML = "a sky diving";
		img.src = "_images/para.png"
	} else if (h < 30000) {
		fallType.innerHTML = "a jet plane";
		img.src = "_images/jet.png"
	} else {
		fallType.innerHTML = "a satellite";
		img.src = "_images/satellite.png"
	}
	fillInResult(paras);
}

/**
 * Fill in parameters when page loaded
 */
document.addEventListener('DOMContentLoaded', function() {
	var paras = getParas();
	fillInContent(paras);
}, false);