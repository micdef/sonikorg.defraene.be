INSERT INTO sys_module (name, descr, callcode, pathjs, namejs, fctload, fctunload, flagmaintenance, flagactive) VALUES ('base', 'Module de base', '000000', null, null, null, null, false, true);
INSERT INTO sys_module (name, descr, callcode, pathjs, namejs, fctload, fctunload, flagmaintenance, flagactive) VALUES ('user', 'Module des utilisateurs', '000001', '/user/', 'user.js', 'user_init', 'user_uninit', false, true);
INSERT INTO sys_module (name, descr, callcode, pathjs, namejs, fctload, fctunload, flagmaintenance, flagactive) VALUES ('menu_tv', 'Menu TeamViewer', '000003', '/menu/', 'menu_tv.js', 'teamviewer_init', 'teamviewer_uninit', false, true);
INSERT INTO sys_module (name, descr, callcode, pathjs, namejs, fctload, fctunload, flagmaintenance, flagactive) VALUES ('lessons', 'Module des cours', '000004', '/lessons', 'lessons.js', 'lessons_init', 'lessons_uninit', false, true);

INSERT INTO sys_category (idmodule, code, fa_icon, file_icon, listorder, flagmaintenance, flagactive) VALUES (3, 'tv', 'fas fa-wrench', null, 1, false, true);
INSERT INTO sys_category (idmodule, code, fa_icon, file_icon, listorder, flagmaintenance, flagactive) VALUES (4, 'lessons', 'fas fa-chalkboard-teacher', null, 2, false, true);

INSERT INTO sys_nodeitem (idcategory, code, fa_icon, file_icon, flagmaintenance, flagactive) VALUES (1, 'tvfull', 'far fa-hand-pointer-o', null, false, true);
INSERT INTO sys_nodeitem (idcategory, code, fa_icon, file_icon, flagmaintenance, flagactive) VALUES (1, 'tvqs', 'far fa-eye', null, false, true);
INSERT INTO sys_nodeitem (idcategory, code, fa_icon, file_icon, flagmaintenance, flagactive) VALUES (2, 'lesscpp', 'fas fa-file-code', null, false, true);
INSERT INTO sys_nodeitem (idcategory, code, fa_icon, file_icon, flagmaintenance, flagactive) VALUES (2, 'lessvb', 'fas fa-desktop-alt', null, false, true);
INSERT INTO sys_nodeitem (idcategory, code, fa_icon, file_icon, flagmaintenance, flagactive) VALUES (2, 'lesshtml', 'fab fa-html5', null, false, true);
INSERT INTO sys_nodeitem (idcategory, code, fa_icon, file_icon, flagmaintenance, flagactive) VALUES (2, 'lesscss', 'fab fa-css3', null, false, true);
INSERT INTO sys_nodeitem (idcategory, code, fa_icon, file_icon, flagmaintenance, flagactive) VALUES (2, 'lessjs', 'fab fa-js-square', null, false, true);
INSERT INTO sys_nodeitem (idcategory, code, fa_icon, file_icon, flagmaintenance, flagactive) VALUES (2, 'lessphp', 'fab fa-php', null, false, true);

INSERT INTO sys_node (idnodeprev, idnodecurr, idnodenext, listorder) VALUES (null, 1, null, 2);
INSERT INTO sys_node (idnodeprev, idnodecurr, idnodenext, listorder) VALUES (null, 2, null, 1);
INSERT INTO sys_node (idnodeprev, idnodecurr, idnodenext, listorder) VALUES (null, 3, null, 1);
INSERT INTO sys_node (idnodeprev, idnodecurr, idnodenext, listorder) VALUES (null, 4, null, 2);
INSERT INTO sys_node (idnodeprev, idnodecurr, idnodenext, listorder) VALUES (null, 5, null, 3);
INSERT INTO sys_node (idnodeprev, idnodecurr, idnodenext, listorder) VALUES (null, 6, null, 4);
INSERT INTO sys_node (idnodeprev, idnodecurr, idnodenext, listorder) VALUES (null, 7, null, 5);
INSERT INTO sys_node (idnodeprev, idnodecurr, idnodenext, listorder) VALUES (null, 8, null, 6);

INSERT INTO usr_user (username, password, firstname, lastname, gender, datein, email, tel, flagactive, flagdelete) VALUES ('dfrmch', '2b9ad7fa8710bab1ae18c3831c647c497dad265d56d4e70bdeb171f07b22aea28e96399446d5c312e7846c52296bf5511b3c05bed684ae189970d8e0dcab8b3e', 'Micha�l', 'Defraene', 'M', '2018-12-01', 'michael.defraene@outlook.be', '+32483006901', true, false);
INSERT INTO usr_user (username, password, firstname, lastname, gender, datein, email, tel, flagactive, flagdelete) VALUES ('dssmrr', 'a8e2bbb6e5c5eb5e03f0a7833b1cb01f84ad6011762d5b9189dfc5ce412f14be3f7ea7708766208dbe3bde7e002f07722f0bbd42ac08ee095abd673b87c5b85b', 'Marie-Aurore', 'Dossogne', 'F', '2018-12-01', 'dossogne.ma@gmail.com', '+32474153578', true, false);

INSERT INTO usr_group (name, descr, flagactive, flagdelete) VALUES ('admin', 'Administrateurs du site', true, false);
INSERT INTO usr_group (name, descr, flagactive, flagdelete) VALUES ('family', 'Famille Defraene', true, false);
INSERT INTO usr_group (name, descr, flagactive, flagdelete) VALUES ('studentalgo', 'Etudiants en algorithmie', true, false);
INSERT INTO usr_group (name, descr, flagactive, flagdelete) VALUES ('studentvb', 'Etudiants en vb.net', true, false);
INSERT INTO usr_group (name, descr, flagactive, flagdelete) VALUES ('studentajax', 'Etudiants en AJAX', true, false);

INSERT INTO usr_lnkusergroup (idgroup, iduser, datein, flagactive, flagdelete) VALUES (1, 1, '2018-12-01', true, false);
INSERT INTO usr_lnkusergroup (idgroup, iduser, datein, flagactive, flagdelete) VALUES (2, 1, '2018-12-01', true, false);
INSERT INTO usr_lnkusergroup (idgroup, iduser, datein, flagactive, flagdelete) VALUES (3, 1, '2018-12-01', true, false);
INSERT INTO usr_lnkusergroup (idgroup, iduser, datein, flagactive, flagdelete) VALUES (4, 1, '2018-12-01', true, false);
INSERT INTO usr_lnkusergroup (idgroup, iduser, datein, flagactive, flagdelete) VALUES (5, 1, '2018-12-01', true, false);
INSERT INTO usr_lnkusergroup (idgroup, iduser, datein, flagactive, flagdelete) VALUES (2, 2, '2018-12-01', true, false);

INSERT INTO tra_lang (code, flagactive) VALUES ('fr-fr', true);
INSERT INTO	tra_lang (code, flagactive) VALUES ('en-en', true);

/* TRA DB FR */
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'tra_lang', 'code', 'fr-fr', 'Fran�ais');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'tra_lang', 'code', 'en-en', 'Anglais');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_category', 'code', 'tv', 'TeamViewer');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_category', 'code', 'lessons', 'Cours');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_nodeitem', 'code', 'tvfull', 'Installation Compl�te');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_nodeitem', 'code', 'tvqs', 'Quick Support');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_nodeitem', 'code', 'lesscpp', 'C++');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_nodeitem', 'code', 'lessvb', 'Visual Basic .net');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_nodeitem', 'code', 'lesshtml', 'HTML');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_nodeitem', 'code', 'lesscss', 'CSS');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_nodeitem', 'code', 'lessjs', 'JavaScript / JQuery');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'sys_nodeitem', 'code', 'lessphp', 'PHP');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'usr_group', 'name', 'admin', 'Administrateur du site');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'usr_group', 'name', 'family', 'Famille Defraene');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'usr_group', 'name', 'studentalgo', 'Etudiants en algorithmie');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'usr_group', 'name', 'studentvb', 'Etudiants en vb.net');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (1, 'usr_group', 'name', 'studentajax', 'Etudiants en web / AJAX');

/* TRA DB EN */
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'tra_lang', 'code', 'fr-fr', 'French');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'tra_lang', 'code', 'en-en', 'English');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_category', 'code', 'tv', 'TeamViewer');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_category', 'code', 'lessons', 'Lessons');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_nodeitem', 'code', 'tvfull', 'Full Install');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_nodeitem', 'code', 'tvqs', 'Quick Support');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_nodeitem', 'code', 'lesscpp', 'C++');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_nodeitem', 'code', 'lessvb', 'Visual Basic .net');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_nodeitem', 'code', 'lesshtml', 'HTML');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_nodeitem', 'code', 'lesscss', 'CSS');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_nodeitem', 'code', 'lessjs', 'JavaScript / JQuery');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'sys_nodeitem', 'code', 'lessphp', 'PHP');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'usr_group', 'name', 'admin', 'Website Administrators');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'usr_group', 'name', 'family', 'Defraene Family');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'usr_group', 'name', 'studentalgo', 'Algorithmic Students');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'usr_group', 'name', 'studentvb', 'Vb.net Students');
INSERT INTO tra_dbtranslation (idlang, nametable, uniqueelement, valueunique, text) VALUES (2, 'usr_group', 'name', 'studentajax', 'Web / AJAX Students');