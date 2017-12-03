var elements = {
	nom: {
		text: $("#nom-span"), 
		field: $("#nom-field"), 
		wrong: $("#nomValidate-span"),
		validator: function(txt) { return txt.length > 1; }
	},
	prenom: {
		text: $("#prenom-span"),
		field: $("#prenom-field"),
		wrong: $("#prenomValidate-span"),
		validator: function(txt) { return txt.length > 1; }
	},
	adresse: { 
		text: $("#adresse-span"), 
		field: $("#adresse-field"), 
		wrong: $("#adressValidate-span"), 
		validator: function(txt) { return txt.length > 1;  }
	},
	ville: {
		text: $("#ville-span"),
		field: $("#ville-field"),
		wrong: $("#addressValidate-span"),
		validator: function(txt) { return txt.length > 1;  }
	},
	cp: {
		text: $("#cp-span"),
		field: $("#cp-field"),
		wrong: $("#cpValidate-span"),
		validator: function(txt) { return /^[0-9]{5}$/.test(txt);  }
	},
	numerotel: { 
		text: $("#numero-span"), 
		field: $("#numero-field"), 
		wrong: $("#numeroValidate-span"), 
		validator: function(txt) { return /^(00213|\+213|0)(5|6|7)[0-9]{8}$/.test(txt);  }
		/* https://github.com/01walid/regex-dz-mobile-phone */ 
	},
	mail: { 
		text: $("#mail-span"),
		field: $("#mail-field"),
		wrong: $("#mailValidate-span"), 
		validator: function(txt) { return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(txt);  }
		/* http://emailregex.com/ */
	}
};

var bt1      = $("#bt_chg_photo");
var bt2      = $("#bt_chg_infos");
var loader   = $("#loaderpic");
var ifp      = $("#ifmdp");
var pwd1     = $("#mdp1");
var pwd2     = $("#mdp2");
var pwdf1    = $("#inp_mdp1");
var pwdf2    = $("#inp_mdp2");
var pwdError = $("#mdpValidate-span");
var errormsg = $("#errormsg");

errormsg.hide();
loader.hide();
ifp.hide();
pwd1.hide();
pwd2.hide();



function toggleForm(showFields, invert){
	for (var k in elements){
		elements[k].text.toggleClass("d-none");
		elements[k].text.toggleClass("d-block");
		elements[k].field.toggleClass("d-block");
		elements[k].field.toggleClass("d-none");

		if(showFields && !invert){
			elements[k].field.val(elements[k].text.text());
		} else if (!showFields && !invert) {
			elements[k].text.text(elements[k].field.val());
		}
	}

	bt1.toggleClass("btn-dark");
	bt2.toggleClass("btn-dark");
	bt1.toggleClass("btn-danger");
	bt2.toggleClass("btn-success");

	if (showFields){
		bt1.text("Annuler");
		bt2.text("Valider");
		ifp.show();
		pwd1.show();
		pwd2.show();
	} else {
		bt1.text("Changer de photo");
		bt2.text("Editer les infos");
		ifp.hide();
		pwd1.hide();
		pwd2.hide();
	}
}

function uploadPic(){
	console.log("Upload picture");
}

function cancel(){
	toggleForm(false, true);
	bt1.unbind("click").click(uploadPic);
	bt2.unbind("click").click(showFields);
}

function showFields(){
	toggleForm(true, false);
	bt1.unbind("click").click(cancel);
	bt2.unbind("click").click(validate);
}

function validateOneField(fld){
	validate = function(){
		console.log("test" + fld);
		currField = elements[fld];
		if (currField.validator(currField.field.val())){
			currField.wrong.addClass("d-none");
			if (currField.wrong.has("d-flex")){
				currField.wrong.removeClass("d-flex");
			}
		} else {
			currField.wrong.addClass("d-flex");
			if (currField.wrong.has("d-none")){
				currField.wrong.removeClass("d-none");
			}
		}
	};

	elements[fld].field.get(0).onkeyup = validate;

	return validate;
}

function validate(){
	bt1.prop("disabled", true);
	bt2.prop("disabled", true);

	// On synchronise la variable userInfo
	userInfo = {};
	for (var k in elements){
		userInfo[k] = elements[k].field.val();
	}

	if (pwdf1.val().length != 0 && pwdf2.val().length != 0 && pwdf1.val() === pwdf2.val()){
		userInfo["mdp"] = pwdf1.val();
	}

	// Faire la requête ajax
	loader.show();
	$.ajax({
			type: "GET",
			url: "/api/updateinfo.php",
			data: userInfo,
			error: function(event, jqXHR, ajaxSettings, thrownError) { 
				console.log(thrownError);
				errormsg.show();
				loader.hide();
				bt1.prop("disabled", false);
				bt2.prop("disabled", false);
			},
			success: function(msg){ 
				loader.hide();
				toggleForm(false, false);
				bt1.unbind("click").click(uploadPic);
				bt2.unbind("click").click(showFields);
				bt1.prop("disabled", false);
				bt2.prop("disabled", false);
				userInfo["mdp"] = "";
			}
		}
	);
}

bt1.click(uploadPic);
bt2.click(showFields);

for (var k in elements){
	elements[k].text.text(userInfo[k]);
	elements[k].isValid = validateOneField(k);
}

validateMdp = function() {
	console.log("test");
	if (pwdf1.val() === pwdf2.val()){
		console.log("Equals");
		pwdError.addClass("d-none");
		if (pwdError.has("d-flex")){
			pwdError.removeClass("d-flex");
		}
	} else {
		console.log("Not equals")
		pwdError.addClass("d-flex");
		if (pwdError.has("d-none")){
			pwdError.removeClass("d-none");
		}
	}

}

pwdf1.get(0).onkeyup = validateMdp;
pwdf2.get(0).onkeyup = validateMdp;
