var btGroupe = $("#btGroupe");
var btAddGroupe = $("#btAddGroupe");
var btMembre = $("#btMembre");
var btStudent = $("#btAdd");
var btCancel = $("#btCancel");
var btAddStudent = $("#btAddStudent");
var btDeleteStudent = $("#btDeleteStudent");
var btDeleteGroup = $("#btDeleteGroup");

var divAddGroupe = $("#addGroupe");
var divGroupe = $("#groupe");
var divAddStudent = $("#divAddStudent");

var selectGroupe = $("#selectGroupe");
var selectMember = $("#selectMember");
var selectStudent = $("#selectStudent");
var selectFormation = $("#selectFormation");

var studentRemove = $("#removeValidate-span");
var groupeRemove = $("#removeGroupeValidate-span")

var nomGroupe = {
    field: $("#nomGroupe-field"),
    wrong: $("#groupeValidate-span"),
    validator: function (txt) {
        return txt.length > 1;
    }
}

var valideStudent = {
    inGroupe: {
        wrong: $("#StudentValidate-span")
    },
    empty: {
        wrong: $("#EmptyValidate-span")
    },
    insere: {
        good: $("#insereValidate-span")
    }
}

btStudent.click(function () {
    selectMember.hide();
    btDeleteStudent.hide();
    showField(divAddStudent);
});

btDeleteStudent.click(function () {
    if (selectMember.val() == null) {
        showField(studentRemove);
    }
    else {
        hideField(studentRemove);
        var ids = "idGroupe=" + selectGroupe.val() + "&idStudent=" + selectMember.val();
        $.ajax({
            type: 'GET',
            url: '/api/deleteStudentGroup.php?' + ids,
            success: function (data) {
                selectMember.empty();
                data = JSON.parse(data);
                for (var k in data) {
                    selectMember.append(new Option(data[k].nom + " " + data[k].prenom + " : " + data[k].userName, data[k].id, false, false));
                }
            },
            error: function (a, b, c, d) {
            }
        })
    }
});

btMembre.click(function () {
    hideField(divAddStudent);
    selectMember.show();
    btDeleteStudent.show();
    hideField(valideStudent.inGroupe.wrong);
    hideField(valideStudent.empty.wrong);
});

selectStudent.change(function () {
    var liste = [];
    var continuer = true;
    var compteur = 0;
    while (continuer) {
        if (selectMember[0][compteur] == null) {
            continuer = false;
        }
        else {
            liste.push(selectMember[0][compteur].value);
            compteur++;
        }
    }

    if (liste.includes(selectStudent.val())) {
        showField(valideStudent.inGroupe.wrong);
        btAddStudent.prop("disabled", true);
    }
    else {
        hideField(valideStudent.inGroupe.wrong);
        btAddStudent.prop("disabled", false);
    }
});

btAddStudent.click(function () {
    var liste = [];
    var continuer = true;
    var compteur = 0;
    while (continuer) {
        if (selectMember[0][compteur] == null) {
            continuer = false;
        }
        else {
            liste.push(selectMember[0][compteur].value);
            compteur++;
        }

        if (liste.includes(selectStudent.val())) {
            showField(valideStudent.inGroupe.wrong);
        }
        else {
            hideField(valideStudent.inGroupe.wrong);

        }
        if (selectGroupe.val() == null) {
            showField(valideStudent.empty.wrong);
        }
        else {
            hideField(valideStudent.empty.wrong);
            var identifiants = "idGroupe=" + selectGroupe.val() + "&idStudent=" + selectStudent.val();
            $.ajax({
                type: 'GET',
                url: '/api/addStudentInGroupe.php?' + identifiants,
                success: function (data) {
                    selectMember.empty();
                    data = JSON.parse(data);
                    for (var k in data) {
                        selectMember.append(new Option(data[k].nom + " " + data[k].prenom + " : " + data[k].userName, data[k].id, false, false));
                    }
                    showField(valideStudent.insere.good);
                    setTimeout(function () {
                        hideField(valideStudent.insere.good);
                    }, 2000);
                },
                error: function (a, b, c, d) {
                }
            })
        }
    }
});

btGroupe.click(function () {
    hideField(divGroupe);
    showField(divAddGroupe);
    btGroupe.hide();
});

btCancel.click(function () {
    hideField(divAddGroupe);
    showField(divGroupe);
    btGroupe.show();
    nomGroupe.field.val("");
});

selectGroupe.change(function () {
    selectMember.empty();
    var idGroupe = "idGroupe=" + selectGroupe.val();
    $.ajax({
        type: 'GET',
        url: '/api/getElevesGroupe.php?' + idGroupe,
        success: function (data) {
            data = JSON.parse(data);
            for (var k in data) {
                selectMember.append(new Option(data[k].nom + " " + data[k].prenom + " : " + data[k].userName, data[k].id, false, false));
            }
        },
        error: function (a, b, c, d) {
        }
    });
})

nomGroupe.field.change(function () {
    var listeLower = [];
    for (var i in listeGroupe) {
        listeLower.push(listeGroupe[i].toLowerCase());
    }
    if (listeLower.includes(nomGroupe.field.val().toLowerCase()) || !nomGroupe.validator(nomGroupe.field.val())) {
        showField(nomGroupe.wrong);
    }
    else {
        hideField(nomGroupe.wrong);
    }
});

btAddGroupe.click(function () {
    var listeLower = [];
    for (var i in listeGroupe) {
        listeLower.push(listeGroupe[i].toLowerCase());
    }
    if (listeLower.includes(nomGroupe.field.val().toLowerCase()) || !nomGroupe.validator(nomGroupe.field.val())) {
        showField(nomGroupe.wrong);
    }
    else {
        hideField(nomGroupe.wrong);
        var newGroupe = "nom=" + nomGroupe.field.val() + "&idFormation=" + selectFormation.val();
        $.ajax({
            type: 'GET',
            url: '/api/addGroupe.php?' + newGroupe,
            success: function (data) {
                data = JSON.parse(data);
                selectGroupe.append(new Option(nomGroupe.field.val() + " - Formation : " + data[1], data[0], false, false));
                listeGroupe.push(nomGroupe.field.val());
                nomGroupe.field.val("");
            },
            error: function (a, b, c, d) {
            }
        });
    }
});

btDeleteGroup.click(function () {
    if (selectGroupe.val() == null) {
        showField(groupeRemove);
    }
    else {
        hideField(groupeRemove);
        if (confirm("Supprimer le groupe?") == true) {
            var idGroupe = "idGroupe=" + selectGroupe.val();
            $.ajax({
                type: 'GET',
                url: '/api/removeGroupe.php?' + idGroupe,
                success: function (data) {
                    console.log(data);
                    $("#selectGroupe option:selected").remove();
                    selectMember.empty();
                    var index = listeGroupe.indexOf(data);
                    console.log(index);
                    delete listeGroupe[index];
                },
                error: function (a, b, c, d) {
                }
            });
        }
    }
});

function showField(field) {
    field.addClass("d-flex");
    field.removeClass("d-none");
}

function hideField(field) {
    field.addClass("d-none");
    field.removeClass("d-flex");
}