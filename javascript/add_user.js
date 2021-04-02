// Version 3.0 - Enhanced to use jquery
// Version 2.0 - enforce mandatory fields
// Version 1.0 - original

// This is the array for error handling
var vError = [];

$(document).ready(function() {
	// We attach to every input field a little js
   parent.document.title=document.title;

	if (document.getElementsByTagName) {
		var vInput = document.getElementsByTagName("input");

		for (var vCount=0; vCount<vInput.length; vCount++)
			vInput[vCount].onblur = function() { return validateIt(this); }
	}

	$("#validate").button({
      icons: {
         primary: "ui-icon-gear",
      	secondary: "ui-icon-triangle-1-s"
      }
   });

	$("#validate").on('click', function() {
	   var returnval=true; //by default, allow form submission
	   var biLingText=new Array("One or more fields was left blank, enter the missing data.");

	   var languageinfo=navigator.language? navigator.language : navigator.userLanguage
	   //alert("Language: " + languageinfo);
	   //document.write("<B>Language: " + languageinfo + "</B><BR>");

	   if (languageinfo.substr(0,2)=="fr") {
	      biLingText=Array("Un ou plusieurs champs sont vides; entrez les donn? manquantes.");
	   }

	   // Some form fields cannot be left blank and this loop checks for that
	   // Fields that can be blank: postal
	   // Fields that cannot be blank: uid, username, address, city, prov, org
	   var label_name = "";
	   var blank_flds = "";
	   //alert("Length = " + document.add_user.elements.length);
	   for (i=0; i<document.add_user.elements.length; i++) {
	   //for (i=0; i<document.getElementById("add_user").length; i++) {
	   	//alert("Name = " + document.add_user.elements[i].name + " Value = " + document.add_user.elements[i].value);
	      if ( (document.add_user.elements[i].value == "") && (document.add_user.elements[i].name != "postal") && (document.add_user.elements[i].name != "app") && (document.add_user.elements[i].name != "cntxt") ) {
	         label_name = document.add_user.elements[i].name + "_lbl";
	         blank_flds += document.getElementById(label_name).innerHTML + "<br>\n"; //alert error message
	         returnval=false;                                                        //disallow form submission
	      }
	   }

	   if (blank_flds != "") {
	      //alert(biLingText[0] + "\n\n" + blank_flds ); //alert error message
	      var theMESSAGE = biLingText[0] + "<br><br>" + blank_flds;
			var theICON = '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span>';
			$("#dialog-message").html('<P>' + theICON + theMESSAGE + '</P>');
			$("#dialog-message").dialog({
				modal: true,
				buttons: {
						Ok: function() {
							$( this ).dialog( "close" );
						}
				}
    		});
	   }

		if (returnval) {
	      	document.add_user.submit();
	   	}
	});
});

// The main validation-function
function validateIt(vInput) {
	// Each input field's id
	vId = vInput.id;
	vValue = vInput.value;

	// Pre Fill fields using data from preceeding fields
	//if (vId == "username") {
	//   preFillemail();
	//}

	// Separate the class attr of each input field
	getValue = vInput.className;
	if (getValue.indexOf(",") == -1 ) {
		vType = getValue;
		vRequired = "";
	} else {
		vRules = vInput.className.split(",");
		vRequired = vRules[0];
		vType = vRules[1];
	}

	// Using the core $.ajax() method
	$.ajax({
	// The URL for the request
	url: "/php/validate.php",
	// The data to send (will be converted to a query string)
	data: {
		value: vValue, required: vRequired, type: vType
	},
	// Whether this is a POST or GET request
	type: "GET",
	// The type of data we expect back
	dataType : "text",
	// Code to run if the request succeeds;
	// the response is passed to the function
	success: function( response ) {
		// Refering to the PHP script, for every validation we'll get
		// either true or false and apply some visual changes in order to
		// get the user focusing on each field whether it's ok or not
		// If one of the input fields contains an error, the submit button
		// will be disabled, until the error (that means all errors) are
		// solved
		if (response == "false") {
			var sInput = document.getElementById(vId);

			document[vId].src = "/images/false.png";
			sInput.style.border = "1px solid #d12f19";
			sInput.style.background = "#f7cbc2";
			// We do a check if our element is already in the error array, and if
			// not, we add it to vError array.  This avoids duplicate array elements.
			if (vError.indexOf(vId) == -1) {
				vError.push(vId);
			}

			$("input[type=button]").prop("disabled",true);
			$("#validate").removeClass( "ui-state-default" ).addClass( "disable-btn" );
		}

		if (response == "true") {
			var sInput = document.getElementById(vId);

			document[vId].src = "/images/true.png";
			sInput.style.border = "1px solid #338800";
			sInput.style.background = "#c7f7be";

			// We do a check if our element is in the error array, and if
			// so, we can delete it from the vError array
			if (vError.indexOf(vId) != -1) {
				var aId = vError.indexOf(vId);
				vError.splice(aId, 1);
				if (vError.length > 0) {
					$("input[type=button]").prop("disabled",true);
					$("#validate").removeClass( "ui-state-default" ).addClass( "disable-btn" );
				} else {
					$("input[type=button]").prop("disabled",false);
					$("#validate").removeClass( "disable-btn" ).addClass( "ui-state-default" );
				}
			}
		}

		if (response == "none") {

			var sInput = document.getElementById(vId);

			document[vId].src = "/images/blank.gif";
			sInput.style.border = "1px solid #aaa";
			sInput.style.background = "#ffffff";

			$("input[type=button]").prop("disabled",false);
			$("#validate").removeClass( "disable-btn" ).addClass( "ui-state-default" );
		}
	},
	// Code to run if the request fails; the raw request and
	// status codes are passed to the function
	error: function( xhr, status, errorThrown ) {
		alert( "Sorry, there was a problem!" );
		console.log( "Error: " + errorThrown );
		console.log( "Status: " + status );
		console.dir( xhr );
	},
	// Code to run regardless of success or failure
	complete: function( xhr, status ) {
		//alert( "The request is complete!" );
	}
	});
}

function preFillemail() {
   var txtPatrn = /^[\w -\']{3,}/;
   if ( (document.getElementById("email").value == "") && txtPatrn.test(document.getElementById("username").value) ) {
   	var email_name = document.getElementById("username").value.replace(" ", ".");  // replace space with period
      var nameTxt=email_name + "@outlook.com";
      document.getElementById("email").value=nameTxt.toLowerCase(); // pre-fill the e-mail field
   }
}