var elementsInsc = {
    nom: {
        field: $("#nomInsc-field"),
        wrong: $("#nomValidateInsc-span"),
        validator: function (txt) {
            return txt.length > 1;
        }
    },
    prenom: {
        field: $("#prenomInsc-field"),
        wrong: $("#prenomValidateInsc-span"),
        validator: function (txt) {
            return txt.length > 1;
        }
    },
    adresse: {
        field: $("#adresseInsc-field"),
        wrong: $("#adressValidateInsc-span"),
        validator: function (txt) {
            return txt.length > 1;
        }
    },
    ville: {
        field: $("#villeInsc-field"),
        wrong: $("#addressValidateInsc-span"),
        validator: function (txt) {
            return txt.length > 1;
        }
    },
    cp: {
        field: $("#cpInsc-field"),
        wrong: $("#cpValidateInsc-span"),
        validator: function (txt) {
            return /^[0-9]{5}$/.test(txt);
        }
    },
    numerotel: {
        field: $("#numeroInsc-field"),
        wrong: $("#numeroValidateInsc-span"),
        validator: function (txt) {
            return /^(00213|\+213|0)(5|6|7)[0-9]{8}$/.test(txt);
        }
        /* https://github.com/01walid/regex-dz-mobile-phone */
    },
    mail: {
        field: $("#mailInsc-field"),
        wrong: $("#mailValidateInsc-span"),
        validator: function (txt) {
            return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(txt);
        }
        /* http://emailregex.com/ */
    }
};
    var ine = {
        div:   $("#INEInsc-div"),
        field: $("#INEInsc-field"),
        wrong: $("#INEValidateInsc-span"),
        validator: function(txt) { return txt.length>1;  }
    };

    var embauche ={
        div:   $("#dateInsc-div"),
        field: $("#dateInsc-field"),
        wrong: $("#dateValidateInsc-span"),
        validator: function(txt) { return /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/.test(txt); }
    }

var select    =$("#formations");
var bt1       =$("#bt_cancelInscrip");
var bt2       =$("#bt_addUser");
var bt3       =$("#addUserButton");
var error     =$("#errorMsgInsc");
var firstForm =$("#userInfo");
var secondForm=$("#userInscription");
var listUser  =$("#userList");
var radio1    =document.getElementById("student");
var radio2    =document.getElementById("teacher");

embauche.div.hide();
error.hide();
secondForm.hide();
setChange();


bt3.click(function(){
   bt3.hide();
   firstForm.hide();
   secondForm.show();
   listUser.addClass("d-none");
   listUser.removeClass("d-flex");
});


bt1.click(function(){
    firstForm.show();
    secondForm.hide();
    bt3.show();
    clear();
    setToZero();
    listUser.addClass("d-flex");
    listUser.removeClass("d-none");
});

radio1.onclick = function(){
    select.show();
    ine.div.addClass("d-flex");
    ine.div.removeClass("d-none");
    embauche.div.addClass("d-none");
    embauche.div.removeClass("d-flex");
    embauche.wrong.removeClass("d-flex");
    embauche.wrong.addClass("d-none");
    embauche.field.val("");
};

radio2.onclick = function(){
    select.hide();
    embauche.div.addClass("d-flex");
    embauche.div.removeClass("d-none");
    ine.div.addClass("d-none");
    ine.div.removeClass("d-flex");
    ine.wrong.removeClass("d-flex");
    ine.wrong.addClass("d-none");
    ine.field.val("");
};

function clear(){
    for(k in elementsInsc){
        elementsInsc[k].field.val("");
    }
    setToZero();
    ine.field.val("");
    embauche.field.val("");
}

function setChange(){
    for(k in elementsInsc){
        setChangeOne(k);
    }
    ine.field.change(function () {
        if (ine.validator(ine.field.val())) {
            ine.wrong.addClass("d-none");
            ine.wrong.removeClass("d-flex");
        } else {
            ine.wrong.addClass("d-flex");
            ine.wrong.removeClass("d-none");
        }
    });

    embauche.field.change(function () {
        if (embauche.validator(embauche.field.val())) {
            embauche.wrong.addClass("d-none");
            embauche.wrong.removeClass("d-flex");
        } else {
            embauche.wrong.addClass("d-flex");
            embauche.wrong.removeClass("d-none");
        }
    });
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
    if((verifyAllField()&& radio1.checked && ine.validator(ine.field.val())) || (verifyAllField() &&radio2.checked && embauche.validator(embauche.field.val()))) {
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
            personne +="&INE="+ine.field.val();
            personne +="&formation="+document.getElementById("formations").value;
            personne +="&type=0";
        }
        else{
            personne +="&date="+embauche.field.val();
            personne +="&type=1";
        }
        $.ajax({
            type: 'GET',
            url: '/api/enterUser.php?'+personne,
            success: function(data){
                clear();
                setToZero();
                WinPrint = window.open('', '', 'letf=0,top=0,toolbar=0,scrollbars=0,status=0');
                WinPrint.document.write(data);
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
            },
            error: function(a, b, c, d){
                $("#errorMsgInsc").removeClass("d-none");
                $("#errorMsgInsc").addClass("d-block");
            }
        });
        clear();
    }
});