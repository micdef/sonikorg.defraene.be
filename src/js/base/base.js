var nbt;
var sbl;
var base_cookie;

function init() {
	nbt = $("#home-navbar");
	sbl = $("#home-sidebar");
	base_cookie = "sonikorg.defraene.be_";
	init_load();
}

function init_load() {
	var fctBackBaseSession = function(rsp) {
		setCookie(base_cookie + "phpsession", rsp, null);
		var fctBackGetBase = function(rsp) {
			load_menus(rsp);
		}
		param = "session=" + getCookie(base_cookie + "phpsession")
		callXHR("GET", "php/base/getBase.php", param, "xml", fctBackGetBase);
	}
	
	callXHR("GET", "php/base/setBaseSession.php", "env=DEV", "text", fctBackBaseSession);
}

function load_menus(menuItem) {
	var tab = xml2ArrayMenu(menuItem);
	for (i = 0; i < tab.length; i++) {
		sbl.append(alte_genSideBarActiveTreeView(tab[i]["category"]["fa_icon"], tab[i]["category"]["text"], tab[i]["node"]));
	}
}

window.onload = init;