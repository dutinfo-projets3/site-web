function clearFields(){
	$("#info").children().not(":last").remove();
}

function addField(leftText, txField, idright, content){
	var madiv = $("<div>");
	madiv.addClass("mt-2 row");
	
	var leftSpan = $("<span>");
	leftSpan.addClass("col-5 d-block" + (txField ? " pt-1" : ""));
	leftSpan.text(leftText);
	madiv.append(leftSpan);

	var rightThing;
	if (txField){
		rightThing = $("<input>");
		rightThing.addClass("col-7");
		rightThing.attr("type", "text");
		rightThing.attr("name", idright);
		rightThing.val(content);
	} else {
		rightThing = $("<span>");
		rightThing.addClass("text-center col-7 d-block");
		rightThing.text(content);
	}
	rightThing.attr("id", idright);

	madiv.append(rightThing);
	$("#info").prepend(madiv);
}

function getFieldVal(val){
	if (actualState){
		return $("#" + val).text();
	} else {
		return $("#" + val).val();
	}
}

function getFieldArray(){
	return {
		nom: getFieldVal("nom"),
		prenom: getFieldVal("prenom"),
		adresse: getFieldVal("adresse"),
		ville: getFieldVal("ville"),
		cp: getFieldVal("cp"),
		numero: getFieldVal("numero"),
		mail: getFieldVal("mail")
	};
}

function buildForm(txField, values){
	if (txField){
		addField("Répéter", txField, "mdp2", "");
		addField("Mot de passe", txField, "mdp", "");
	}

	addField("Email", txField, "mail", values["mail"]);
	addField("Numéro", txField, "numero", values["numero"]);
	addField("Code postal", txField, "cp", values["cp"]);
	addField("Ville", txField, "ville", values["ville"]);
	addField("Adresse", txField, "adresse", values["adresse"]);
	addField("Prénom", txField, "prenom", values["prenom"]);
	addField("Nom", txField, "nom", values["nom"]);

}

function toggleToField(){
	currValues = getFieldArray();
	clearFields();
	buildForm(true, currValues);
}

function toggleToText(){

	// Verifier les champs
	// Envoyer au fichier 

}

function updatePhotoAction(){

}

function cancelInfoOptions(){

}
$("#bt_chg_infos").click("toggleToField");
