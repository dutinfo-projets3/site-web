var elements = {
	nom: { text: $("#nom-span"), field: $("#nom-field") },
	prenom: { text: $("#prenom-span"), field: $("#prenom-field") },
	adresse: { text: $("#adresse-span"), field: $("#adresse-field") },
	ville: { text: $("#ville-span"), field: $("#ville-field") },
	cp: { text: $("#cp-span"), field: $("#cp-field") },
	numerotel: { text: $("#numero-span"), field: $("#numero-field") },
	mail: { text: $("#mail-span"), field: $("#mail-field") }
};

var bt1      = $("#bt_chg_photo");
var bt2      = $("#bt_chg_infos");
var loader   = $("#loaderpic");
var ifp      = $("#ifmdp");
var pwd1     = $("#mdp1");
var pwd2     = $("#mdp2");
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

function validate(){
	bt1.prop("disabled", true);
	bt2.prop("disabled", true);

	// Vérifier le text
	
	userInfo = {
		nom: elements["nom"].field.val(),
		prenom: elements["prenom"].field.val(),
		adresse: elements["adresse"].field.val(),
		ville: elements["ville"].field.val(),
		cp: elements["cp"].field.val(),
		numerotel: elements["numerotel"].field.val(),
		mail: elements["mail"].field.val()
	};

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
				console.log(msg);
				loader.hide();
				toggleForm(false, false);
				bt1.unbind("click").click(uploadPic);
				bt2.unbind("click").click(showFields);
				bt1.prop("disabled", false);
				bt2.prop("disabled", false);
			}
		}
	);
}

bt1.click(uploadPic);
bt2.click(showFields);

for (var k in elements){
	elements[k].text.text(userInfo[k]);
}
