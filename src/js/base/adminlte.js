//******************************************************************************
//* File 				: adminlte.js										   *
//* Language 			: JavaScript										   *
//* Author				: Michaël Defraene									   *
//* Company				: SonikOrg | Made by Michaël Defraene				   *
//* Creation Date		: 24/03/2018										   *
//* Description :															   *
//*		File with all adminLTE HTML Elements								   *
//******************************************************************************

//******************************************************************************
//*																			   *
//* PART 0 : NavBar Elements										   		   *
//*																			   *
//******************************************************************************
function alte_navbarSession(logged, user, ocLogin, ocRegister, ocProfile, ocLogout) {
	var sessionObject = alte_genNavbarEl("session", 0, logged);
	var session = ["logged", "user", "functions"];
	session["user"] = user;
	session["logged"] = logged;
	session["functions"] = ["ocLogin", "ocRegister", "ocProfile", "ocLogout"];
	session["functions"]["ocLogin"] = ocLogin;
	session["functions"]["ocRegister"] = ocRegister;
	session["functions"]["ocProfile"] = ocProfile;
	session["functions"]["ocLogout"] = ocLogout;
	sessionObject.append(alte_genNavbarElMenu("session", 0, null, session));
	return sessionObject;
}

function alte_navbarMessage() {
	var messageObject = alte_genNavbarEl("message", 0, null);
	messageObject.append(alte_genNavbarElMenu("message", 0, null, null));
	return messageObject;
}

function alte_navbarNotification() {
	var notificationObject = alte_genNavbarEl("notification", 0, null);
	notificationObject.append(alte_genNavbarElMenu("notification", 0, null, null));
	return notificationObject;
}

function alte_navbarTask() {
	var taskObject = alte_genNavbarEl("task", 0, null);
	taskObject.append(alte_genNavbarElMenu("task", 0, null, null));
	return taskObject;
}

function alte_genNavbarEl(type, nb, logged) {
	switch(type) {
		case "message":
		case "notification":
		case "task":
			console.log("dropdown " + type + "s-menu");
			var el = generateLI("dropdown " + type + "s-menu", null, null);
			console.log(el);
			var a = generateA("dropdown-toggle", "dropdown", "#", null, null);
			a.attr("aria-expanded", "false");
			var i = generateI("fa fa-" + (type == "message" ? "envelope" : (type == "notification" ? "bell" : "flag")) + "-o", null);
			var span = generateSPAN("label label-" + (type == "task" ? "danger" : "warning"), nb);
			a.append(i);
			a.append(span);
			el.append(a);
			return el;
			break;
					
		case "session":
			var el = generateLI("dropdown user user-menu", null, null);
			var a = generateA("dropdown-toggle", "dropdown", "#", "", null);
			a.attr("aria-expanded", "false");
			if(logged){
				
			}else{
				var i = generateI("fas fa-lock text-orange");
				var span = generateSPAN("hidden-xs", "Session");
				a.append(i);
				a.append(span);
			}
			el.append(a);
			return el;
			break;
	}
}

function alte_genNavbarElMenu(type, nb, elements, session) {
	var el = generateUL("dropdown-menu");
	switch(type) {
		case "message":
		case "notification":
		case "task":
			var header = generateLI("header", (nb > 1 ? "Vous avez " + nb + " " + type + "s" : "Vous avez " + nb + " " + type), null);
			var body = generateLI(null, null, null);
			var bodyUL = generateUL("menu");
			for (i = 0; i < nb; i++)
				alte_genNavBarMenuItem(type, elements[i]);
			body.append(bodyUL);
			var footer = generateLI("footer", null, null);
			var footerA = generateA(null, null, null, "Voir " + (type == "notification" || type == "tâche" ? "toutes" : "tous") + " les " + type + "s");
			footer.append(footerA);
			el.append(header);
			el.append(body);
			el.append(footer);
			break;
			
		case "session":
			if(session["logged"]) {
				
			} else {
				var element = ["function", "icon", "text"];
				element["function"] = session["functions"]["ocLogin"];
				element["icon"] = "fas fa-sign-in-alt text-green";
				element["text"] = "Se connecter";
				el.append(alte_genNavBarMenuItem("sessionNOK", element));
				element["function"] = session["functions"]["ocRegister"];
				element["icon"] = "fas fa-user-plus text-orange";
				element["text"] = "S'enregistrer";
				el.append(alte_genNavBarMenuItem("sessionNOK", element));
			}
			break;
	}
	return el;
}

function alte_genNavBarMenuItem(type, element) {
	switch(type) {
		case "message":
			var el = generateLI(null);
			var elA = generateA(null, null, "#", null, element["function"]);
			var elIMGDIV = generateDIV("pull-left", null, null);
			var elIMG = generateIMG(element["img"], "img-circle", element["alt"]);
			elIMGDIV.append(elIMG);
			var elH4 = generateH(4, null, element["title"]);
			var elH4SMALL = generateSMALL(null, null);
			var elH4SMALLI = generateI("fa fa-clock-o");
			elH4SMALL.prepend(elH4SMALLI);
			var elP = generateP(null, element["text"]);
			elH4.append(elH4SMALL);
			elA.append(elIMGDIV);
			elA.append(elH4);
			elA.append(elP);
			el.append(elA);
			return el;
			break;
			
		case "task":
			var el = generateLI(null);
			var elA = generateA(null, null, "#", null, element["function"]);
			var elH3 = generateH(3, null, element["title"]);
			var elDIV = generateDIV("progress xs", null);
			var elProgress = generateDIV("progress-bar progress-bar-" + element["color"], null);
			elProgress.style("width", "20%");
			elProgress.attr("role", "progressbar");
			elProgress.attr("aria-valuenow", element["pctProgress"]);
			elProgress.attr("aria-valuemin", "0");
			elProgress.attr("aria-valuemax", "100");
			var elSPAN = generateSPAN("sr-only", element["pctProgress"]% Complété);
			elProgress.append(elSPAN);
			elDIV.append(elProgress);
			elA.append(elH3);
			elA.append(elDIV);
			el.append(elA);
			break;
			
		case "notification":
		case "sessionNOK":
			var el = generateLI(null);
			var elA = generateA(null, null, "#", null, element["function"]);
			var elI = generateI(element["icon"]);
			elI.css("width", "10%");
			var elSPAN = generateSPAN(null, element["text"]);
			elSPAN.css("width", "90%");
			elA.append(elI);
			elA.append(elSPAN);
			el.append(elA);
			return el;
			break;
			
		case "sessionOK":
			break;
	}
}

//******************************************************************************
//*																			   *
//* PART 1 : SideBar Elements										   		   *
//*																			   *
//******************************************************************************
function alte_genSideBarElementBase(fa_icon, text, oc) {
	var li = generateLI("treeview", null, null);
	var a = generateA(null, null, "#", null, oc);
	var i = generateI(fa_icon, null);
	var span = generateSPAN(null, text);
	a.append(i);
	a.append(span);
	li.append(a);
	return li;
}

function alte_genSideBarActiveTreeView(fa_icon, text, elements) {
	var li = generateLI("treeview");
	var a = generateA(null, null, "#", null, null);
	var i = generateI(fa_icon, null);
	var spanName = generateSPAN(null, text);
	var spanArrow = generateSPAN("pull-right-container", null);
	var spanArrowI = generateI("fa fa-angle-left pull-right");
	a.append(i);
	a.append(spanName);
	spanArrow.append(spanArrowI);
	a.append(spanArrow);
	li.append(a);
	var ul = generateUL("treeview-menu");
	ul.css("display", "none");
	for (var i = 0; i < elements.length; i++) {
		ul.append(alte_genSideBarElementBase(elements[i]["fa_icon"], elements[i]["text"], elements[i]["oc"]));
	}
	li.append(ul);
	return li;
}

function alte_genSideBarMultiLevelTreeView(fa_icon, text, tvEl) {
	var li = generateLI("treeview");
	var a = generateA(null, null, "#", null, null);
	var i = generateI(fa_icon, null);
	var spanName = generateSPAN(null, text);
	var spanArrow = generateSPAN("pull-right-container", null);
	var spanArrowI = generateI("fa fa-angle-left pull-right");
	a.append(i);
	a.append(spanName);
	spanArrow.append(spanArrowI);
	a.append(spanArrow);
	li.append(a);
	var ul = generateUL("treeview-menu");
	ul.css("display", "none");
	console.log(tvEl.length);
	for (var i = 0; i< tvEl.length; i++) {
		console.log(tvEl[i]);
		ul.append(alte_genSideBarActiveTreeView(tvEl[i]["fa_icon"], tvEl[i]["text"], tvEl[i]["elements"]));
	}
	li.append(ul);
	return li;
}
