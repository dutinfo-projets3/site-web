var date = moment();
var edt = [];

var weekDays = [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];

function fillWithWeek(date){
	var cal = document.getElementById("cald");

	while(cal.firstChild){
		cal.removeChild(cal.firstChild);
	}

	var date = moment(date).week("isoweek");

	$("#sem").text("Semaine " + date.week());

	$("#monday").text("Lundi " + date.day("Monday").format("DD/MM"));
	$("#tuesday").text("Mardi " + date.day("Tuesday").format("DD/MM"));
	$("#wednesday").text("Mercredi " + date.day("Wednesday").format("DD/MM"));
	$("#thursday").text("Jeudi " + date.day("Thursday").format("DD/MM"));
	$("#friday").text("Vendredi " + date.day("Friday").format("DD/MM"));
	$("#saturday").text("Samedi " + date.day("Saturday").format("DD/MM"));

	for (i = 8; i <= 21; i++){
		var tr = document.createElement("tr");
		var th = document.createElement("th")
		th.setAttribute("scope", "row");
		th.innerText = i + "h - " + (i+1) + "h";

		tr.appendChild(th);

		// Chaque jour de chaque heure
		for (curD in weekDays){
			day = date.day(weekDays[curD]);
			a = document.createElement("td");
			a.style.minHeight="100px";
			found = false;
			count = 0;
			while (!found && count < edt.length){
				currentDate = edt[count].startDate.toJSDate();

				if (((moment(currentDate)).format("DDMMYYYY") == moment(day).format("DDMMYYYY")) && currentDate.getHours() == i){
					found = edt[count];
				}
				++count;
			}
			if (found){
				var momentEnd = moment(found.endDate.toJSDate());
				var momentStr = moment(found.startDate.toJSDate());
				diff = moment.duration(momentEnd.diff(momentStr)).asHours();
				a.setAttribute("rowspan", diff);

				var cours = document.createElement("div");
				
				var name = document.createElement("span");
				name.style.display = "inline-block";
				name.innerText = found.summary;
				cours.appendChild(name);

				var desc = document.createElement("div");
				desc.style.display = "inline-block";
				desc.style.fontSize = "12px";
				dcArr = found.description.split("\n");
				dcArr.forEach(function (e){
					line = document.createElement("span");
					line.innerText = e;
					line.style.display = "block";
					desc.appendChild(line);
				});
				
				cours.appendChild(desc);

				if (found.summary.startsWith("TD")){
					border = "red";
					bg     = "255, 0, 0";
				} else if (found.summary.startsWith("CM")){
					border = "green";
					bg = "0, 255, 0";
				} else if (found.summary.startsWith("TP")){
					border = "orange";
					bg = "150, 100, 0";
				} else {
					border = "blue";
					bg = "0, 0, 255";
				}

				cours.style.border = "1px solid " + border;
				cours.style.background = "rgba(" + bg + ", .3)";
				cours.style.padding = "2px";

				// Temporaire, juste le temps de savoir cmt faire remplir le div dans le a
				a.style.background = "rgba(" + bg + ", .1)";

				a.appendChild(cours);
			}
			tr.appendChild(a);
		}
		cal.appendChild(tr);
	}
}

function plusOne(){
	date = date.add(1, 'week');
	fillWithWeek(date);
}

function remOne(){
	date = date.subtract(1, "week");
	fillWithWeek(date);
}

$.ajax({
	url: '/api/getcal.php?user=' + username,
	type: 'GET',
	success: function(tx, status){
		var jcal = ICAL.parse(tx);
		comp = new ICAL.Component(jcal);

		$.each(comp.getAllSubcomponents("vevent"), function(a, b){
			edt.push(new ICAL.Event(b));
		});

		fillWithWeek(date);
	},
	error: function(res, status, err){
		console.log(err);
	}
});

