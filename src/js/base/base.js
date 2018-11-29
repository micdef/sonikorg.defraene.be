var nbt;
var sbl;

function init() {
	nbt = $("#home-navbar");
	sbl = $("#home-sidebar");
	drawNavBarTop(false);
	drawSideBarLeft(true);
}

function drawNavBarTop(logged) {
	if (logged == true) {
		
	} else {
		nbt.append(alte_navbarSession(false, null, null, null, null, null));
	}
}

function drawSideBarLeft(logged) {
	
	// TeamViewer
	var arrTeamViewer = [0,1];
	arrTeamViewer[0] = {'fa_icon' : 'far fa-eye', 'text' : ' Quick Support', 'oc' : null};
	arrTeamViewer[1] = {'fa_icon' : 'far fa-hand-pointer-o', 'text' : ' Full Install', 'oc' : null};
	sbl.append(alte_genSideBarActiveTreeView('fas fa-wrench', ' TeamViewer', arrTeamViewer));
	
	// Session
	if (logged == true) {
		
		// Lessons
		var arrLessons = [0,1,2,3];
		arrLessons[0] = {'fa_icon' : 'fab fa-html5', 'text' : ' HTML', 'oc' : null};
		arrLessons[1] = {'fa_icon' : 'fab fa-css3', 'text' : ' CSS', 'oc' : null};
		arrLessons[2] = {'fa_icon' : 'fab fa-js-square', 'text' : ' JavaScript', 'oc' : null};
		arrLessons[3] = {'fa_icon' : 'fab fa-php', 'text' : ' PHP', 'oc' : null};
		sbl.append(alte_genSideBarActiveTreeView('fas fa-chalkboard-teacher', ' Lessons', arrLessons));
		
		// Cloud Computing
		var arrFilesType = [0,1];
		var arrVideosType = [0,1,2];
		arrVideosType[0] = {'fa_icon' : 'fas fa-film', 'text' : ' Movies', 'oc' : null};
		arrVideosType[1] = {'fa_icon' : 'fas fa-video', 'text' : ' Series', 'oc' : null};
		arrVideosType[2] = {'fa_icon' : 'fas fa-certificate', 'text' : ' Mangas', 'oc' : null};
		arrFilesType[0] = {'fa_icon' : 'fas fa-film', 'text' : ' Videos', 'elements' : arrVideosType};
		var arrGamesType = [0,1,2];
		arrGamesType[0] = {'fa_icon' : 'fab fa-critical-role', 'text' : ' RPG', 'oc' : null};
		arrGamesType[1] = {'fa_icon' : 'fab fa-fantasy-flight-games', 'text' : ' Visual Novel', 'oc' : null};
		arrGamesType[2] = {'fa_icon' : 'fas fa-trophy', 'text' : ' FPS', 'oc' : null};
		arrFilesType[1] = {'fa_icon' : 'fas fa-gamepad', 'text' : ' Games', 'elements' : arrGamesType};
		sbl.append(alte_genSideBarMultiLevelTreeView('fas fa-cloud', ' Cloud Computing', arrFilesType));
	}
}

window.onload = init;