<?php

/*
 * This is the PHP script to validate the form over AJAX
 * Validations types possible:
 *
 * - alpha
 * - alphaSpc
 * - alphanum
 * - alphanumSpc
 * - date
 * - email
 * - integer
 * - real
 * - phone
 * - ip
 * - url
 * - postcode
 * - password
 *
 */


// Start the main function
StartValidate();

function StartValidate() {

	// Assign some var's for the requests
	$required = $_GET["required"];
	$type = $_GET["type"];
	$value = $_GET["value"];

	// This is the function to check if a field is even required or not
	// So it's useful if you only want to check if it isn't empty
	validateRequired($required, $value, $type);

	switch ($type) {
		case 'integer':
			validateInteger($value);
			break;
	   case 'real':
			validateRealNumber($value);
			break;
		case 'phone':
			validatePhone($value);
			break;
		case 'alphanum':
			validateAlphanum($value);
			break;
		case 'alpha':
			validateAlpha($value);
			break;
		case 'alphanumSpc':
			validateAlphanumSpc($value);
			break;
		case 'alphaSpc':
			validateAlphaSpc($value);
			break;
		case 'date':
			validateDate($value);
			break;
		case 'email':
			validateEmail($value);
			break;
	   case 'ip':
			validateIP($value);
			break;
		case 'url':
			validateUrl($value);
			break;
		case 'postcode':
			validatePostal($value);
			break;
		case 'password':
			validatePWD($value);
			break;
	}
}

// The function to check if a field is required or not
function validateRequired($required, $value, $type) {
	if($required == "required") {

		// Check if we got an empty value
		if($value == "") {
			echo "false";
			exit();
		}
	} else {
		if($value == "") {
			echo "none";
			exit();
		}
	}
}

// Validation of an Email Address
function validateEmail($value) {
	$isValid = filter_var($value, FILTER_VALIDATE_EMAIL);
	if ($isValid == $value) {
		echo "true";
	} else {
		echo "false";
	}
}

// Validation of a date
function validateDate($value) {
	$pattern = '/^(([1-9])|(0[1-9])|(1[0-2]))\/(([0-9])|([0-2][0-9])|(3[0-1]))\/(([0-9][0-9])|([1-2][0,9][0-9][0-9]))$/';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of characters
function validateAlpha($value) {
	$pattern = '/^[a-zA-Zавдзийк\']+$/u';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of characters and numbers
function validateAlphanum($value) {
	$pattern = '/^[\w]+$/u';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of characters, spaces, etc
function validateAlphaSpc($value) {
	$pattern = '/^[\w\.\,\/() \-\']+$/u';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of characters and numbers
function validateAlphanumSpc($value) {
   $pattern = '/^[\w\.\,\/() \-\']+$/u';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of an integer
function validateInteger($value) {
	$pattern = '/^[0-9]+$/';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of a real number
function validateRealNumber($value) {
	$pattern = '/^[0-9]+\.[0-9]{2}$/';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of phone numbers
function validatePhone($value) {
	$pattern = '/^(867|250|778|250|587|780|403|306|204|807|249|705|226|519|289|905|416|647|343|613|438|514|450|579|819|418|581|506|902|709|604|866|888|800)\-[0-9]{3}\-[0-9]{4}$/';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of an IPv4 address
function validateIP($value) {
	$isValid = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
	if ($isValid == $value) {
		echo "true";
	} else {
		echo "false";
	}
}

// Validation of Postal Codes
function validatePostal($value) {
	$pattern = '/^[a-zA-Z][0-9][a-zA-Z] [0-9][a-zA-Z][0-9]$/';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of an URL
function validateUrl($value) {
	$pattern = '/^(http|https|ftp)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\-\._\?\,\'/\\\+&amp;%\$#\=~])*[^\.\,\)\(\s]$/';
	if (preg_match($pattern, $value)) {
	   echo "true";
	} else {
	   echo "false";
   }
}

// Validation of password
function validatePWD($value) {
   $pattern = '/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\d]).*$/';
	if (preg_match($pattern, $value)) {
		echo "true";
	} else {
		echo "false";
	}
}

?>
