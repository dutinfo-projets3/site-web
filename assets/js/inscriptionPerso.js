var elementsInsc = {
    nom: {
        field: $("#nomInsc-field"),
        wrong: $("#nomValidateInsc-span"),
        validator: function(txt) { return txt.length > 1; }
    },
    prenom: {
        field: $("#prenomInsc-field"),
        wrong: $("#prenomValidateInsc-span"),
        validator: function(txt) { return txt.length > 1; }
    },
    adresse: {
        field: $("#adresseInsc-field"),
        wrong: $("#adressValidateInsc-span"),
        validator: function(txt) { return txt.length > 1;  }
    },
    ville: {
        field: $("#villeInsc-field"),
        wrong: $("#addressValidateInsc-span"),
        validator: function(txt) { return txt.length > 1;  }
    },
    cp: {
        field: $("#cpInsc-field"),
        wrong: $("#cpValidateInsc-span"),
        validator: function(txt) { return /^[0-9]{5}$/.test(txt);  }
    },
    numerotel: {
        field: $("#numeroInsc-field"),
        wrong: $("#numeroValidateInsc-span"),
        validator: function(txt) { return /^(00213|\+213|0)(5|6|7)[0-9]{8}$/.test(txt);  }
        /* https://github.com/01walid/regex-dz-mobile-phone */
    },
    mail: {
        field: $("#mailInsc-field"),
        wrong: $("#mailValidateInsc-span"),
        validator: function(txt) { return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(txt);  }
        /* http://emailregex.com/ */
    }
};

var bt1       =$("#bt_cancelInscrip");
var bt2       =$("#bt_addUser");
var bt3       =$("#addUserButton");
var error     =$("#errorMsgInsc");
var firstForm =$("#userInfo");
var secondForm=$("#userInscription");
var radio1    =document.getElementById("student");
var radio2    =document.getElementById("teacher");

error.hide();
secondForm.hide();
setChange();


bt3.click(function(){
   bt3.hide();
   firstForm.hide();
   secondForm.show();
});


bt1.click(function(){
    firstForm.show();
    secondForm.hide();
    bt3.show();
    clear();
    setToZero();
});

function clear(){
    for(k in elementsInsc){
        elementsInsc[k].field.val("");
        setToZero();
    }
}

function setChange(){
    for(k in elementsInsc){
        setChangeOne(k);
    }
}

function setChangeOne(field) {
        var actualField = elementsInsc[field];
        actualField.field.change(function () {
            if (actualField.validator(actualField.field.val())) {
                actualField.wrong.addClass("d-none");
                actualField.wrong.removeClass("d-flex");
            } else {
                actualField.wrong.addClass("d-flex");
                actualField.wrong.removeClass("d-none");
            }
        });
}

function setToZero(){
    for(var k in elementsInsc){
        elementsInsc[k].wrong.addClass("d-none");
        elementsInsc[k].wrong.removeClass("d-flex");
    }
}

function verifyAllField(){
    var validate = true;
    for(var k in elementsInsc){
        validate = validate && elementsInsc[k].validator(elementsInsc[k].field.val());
    }
    return validate;
}

bt2.click(function(){
    if(verifyAllField()) {
        var personne = "";
        for (k in elementsInsc) {
            if (personne == "") {
                personne = k + "=" + elementsInsc[k].field.val();
            }
            else {
                personne += "&" + k + "=" + elementsInsc[k].field.val();
            }
        }
        if(radio1.checked){
            personne +="&type=0";
        }
        else{
            personne +="&type=1";
        }
        $.ajax({
            type: 'GET',
            url: '/api/enterUser.php?'+personne,
            success: function(data){
                clear();
                setToZero();
            },
            error: function(a, b, c, d){
                $("#erreurimg").removeClass("d-none");
                $("#erreurimg").addClass("d-block");
            }
        });
    }
});