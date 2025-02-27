/* Base System */
CREATE TABLE sys_module
(	idmodule			SERIAL			NOT NULL,
	name				VARCHAR(50)		NOT NULL,
	descr				VARCHAR(4000)	NULL,
	callcode			VARCHAR(6)		NOT NULL,
	pathjs				VARCHAR(4000)	NULL,
	namejs				VARCHAR(255)	NULL,
	fctload				VARCHAR(255)	NULL,
	fctunload			VARCHAR(255)	NULL,
	flagmaintenance		BOOLEAN			NOT NULL,
	flagactive			BOOLEAN			NOT NULL,
	CONSTRAINT	"PK-SYS_Module-IDModule"				PRIMARY KEY	(idmodule),
	CONSTRAINT	"UK-SYS_Module-Name"					UNIQUE		(name),
	CONSTRAINT	"UK-SYS_Module-Callcode"				UNIQUE		(callcode)
);

CREATE TABLE sys_category
(	idcategory			SERIAL			NOT NULL,
	idmodule			INT				NOT NULL,
	code				VARCHAR(10)		NOT NULL,
	fa_icon				VARCHAR(255)	NULL,
	file_icon			VARCHAR(4000)	NULL,
	listorder			INT				NOT NULL,
	flagmaintenance		BOOLEAN			NOT NULL,
	flagactive			BOOLEAN			NOT NULL,
	CONSTRAINT	"PK-SYS_Category-IDCategory"			PRIMARY KEY	(idcategory),
	CONSTRAINT	"FK-SYS_Category-IDModule"				FOREIGN KEY	(idmodule)					REFERENCES	sys_module(idmodule),
	CONSTRAINT	"UK-SYS_Category-Code"					UNIQUE		(code),
	CONSTRAINT	"UK-SYS_Category-ListOrder"				UNIQUE		(listorder)
);

CREATE TABLE sys_nodeitem
(	idnodeitem			SERIAL			NOT NULL,
	idcategory			INT				NOT NULL,
	code				VARCHAR(10)		NOT NULL,
	fa_icon				VARCHAR(255)	NULL,
	file_icon			VARCHAR(4000)	NULL,
	flagmaintenance		BOOLEAN			NOT NULL,
	flagactive			BOOLEAN			NOT NULL,
	CONSTRAINT	"PK-SYS_NodeItem-IDNodeItem"			PRIMARY KEY	(idnodeitem),
	CONSTRAINT	"FK-SYS_NodeItem-IDCategory"			FOREIGN KEY	(idcategory)				REFERENCES	sys_category(idcategory),
	CONSTRAINT	"UK-SYS_NodeItem-Code"					UNIQUE		(code)
);

CREATE TABLE sys_node
(	idnode				SERIAL			NOT NULL,
	idnodeprev			INT				NULL,
	idnodecurr			INT				NOT NULL,
	idnodenext			INT				NULL,
	listorder			INT				NOT NULL,
	CONSTRAINT	"PK-SYS_Node-IDNode"					PRIMARY KEY	(idnode),
	CONSTRAINT	"FK-SYS_Node-IDNodePrev"				FOREIGN KEY	(idnodeprev)				REFERENCES	sys_nodeitem(idnodeitem),
	CONSTRAINT	"FK-SYS_Node-IDNodeCurr"				FOREIGN KEY	(idnodecurr)				REFERENCES	sys_nodeitem(idnodeitem),
	CONSTRAINT	"FK-SYS_Node-IDNodeNext"				FOREIGN KEY (idnodenext)				REFERENCES	sys_nodeitem(idnodeitem),
	CONSTRAINT	"UK-SYS_Node-IDP_IDC"					UNIQUE		(idnodeprev, idnodecurr),
	CONSTRAINT	"UK-SYS_Node-IDC_IDN"					UNIQUE		(idnodecurr, idnodenext),
	CONSTRAINT	"UK-SYS_Node-IDP_IDC_IDN_LO"			UNIQUE		(idnodeprev, idnodecurr, idnodenext, listorder)
);

/* User Module */
CREATE TABLE usr_user
(	iduser				SERIAL			NOT NULL,
	username			VARCHAR(255)	NOT NULL,
	password			VARCHAR(255)	NOT NULL,
	firstname			VARCHAR(255)	NOT NULL,
	lastname			VARCHAR(255)	NOT NULL,
	gender				VARCHAR(1)		NOT NULL	CHECK	(gender	IN	('M','F','X')),
	datein				DATE			NOT NULL,
	email				VARCHAR(4000)	NOT NULL,
	tel					VARCHAR(25)		NULL,
	flagactive			BOOLEAN			NOT NULL,
	flagdelete			BOOLEAN			NOT NULL,
	CONSTRAINT	"PK-USR_User-IDUser"					PRIMARY KEY	(iduser),
	CONSTRAINT	"UK-USR_User-Username"					UNIQUE		(username),
	CONSTRAINT	"UK-USR_User-EMail"						UNIQUE		(email)
);

CREATE TABLE usr_group
(	idgroup				SERIAL			NOT NULL,
	name				VARCHAR(255)	NOT NULL,
	descr				VARCHAR(255)	NULL,
	flagactive			BOOLEAN			NOT NULL,
	flagdelete			BOOLEAN			NOT NULL,
	CONSTRAINT	"PK-USR_Group-IDGroup"					PRIMARY KEY	(idgroup),
	CONSTRAINT	"UK-USR_Group-Name"						UNIQUE		(name)
);

CREATE TABLE usr_lnkusergroup
(	idgroup				INT				NOT NULL,
	iduser				INT				NOT NULL,
	datein				DATE			NOT NULL,
	flagactive			BOOLEAN			NOT NULL,
	flagdelete			BOOLEAN			NOT NULL,
	CONSTRAINT	"UK-USR_LNKUserGroup-IDU_IDG"			PRIMARY KEY	(iduser, idgroup),
	CONSTRAINT	"FK-USR_LNKUserGroup-IDGroup"			FOREIGN KEY	(idgroup)					REFERENCES	usr_group(idgroup),
	CONSTRAINT	"FK-USR_LNKUserGroup-IDUser"			FOREIGN KEY	(iduser)					REFERENCES	usr_user(iduser)
);

CREATE TABLE usr_rights
(
);

CREATE TABLE usr_visitor
(	idvisitor			SERIAL			NOT NULL,
	iduser				INT				NOT NULL,
	datein				DATE			NOT NULL,
	timein				TIME			NOT NULL,
	CONSTRAINT	"PK-USR_Visitor-IDVisitor"				PRIMARY KEY	(idvisitor),
	CONSTRAINT	"FK-USR_Visitor-IDUser"					FOREIGN KEY	(iduser)					REFERENCES	usr_user(iduser)
);

CREATE TABLE usr_token
(	idtoken				SERIAL			NOT NULL,
	hashtoken			VARCHAR(255)	NOT NULL,
	iduser				INT				NOT NULL,
	action				VARCHAR(10)		NOT NULL,
	timevalid			INT			NOT NULL,
	param				VARCHAR(4000)	NOT NULL,
	CONSTRAINT	"PK-USR_Token-IDToken"					PRIMARY KEY	(idtoken),
	CONSTRAINT	"FK-USR_Token-IDUser"					FOREIGN KEY	(iduser)					REFERENCES	usr_user(iduser),
	CONSTRAINT	"UK-USR_Token-HashToken"				UNIQUE		(hashtoken),
	CONSTRAINT	"UK-USR_Token-IDUser_Action"			UNIQUE		(iduser, action)
);

/* Translations */
CREATE TABLE tra_lang
(	idlang				SERIAL			NOT NULL,
	code				VARCHAR(10)		NOT NULL,
	flagactive			BOOLEAN			NOT NULL,
	CONSTRAINT	"FK-TRA_Lang-IDLang"					PRIMARY KEY (idlang),
	CONSTRAINT	"UK-TRA_Lang-Code"						UNIQUE		(code)
);

CREATE TABLE tra_dbtranslation
(	idtra				SERIAL			NOT NULL,
	idlang				INT				NOT NULL,
	nametable			VARCHAR(255)	NOT NULL,
	uniqueelement		VARCHAR(255)	NOT NULL,
	text				VARCHAR(4000)	NOT NULL,
	CONSTRAINT	"PK-TRA_DBTranslation-IDTra"			PRIMARY KEY	(idtra),
	CONSTRAINT	"FK-TRA_DBTranslation-IDLang"			FOREIGN KEY	(idlang)					REFERENCES	tra_lang(idlang),
	CONSTRAINT	"UK-TRA_DBTranslation-1"				UNIQUE		(idlang, nametable, uniqueelement)
);

CREATE TABLE tra_sitetranslation
(	idtra				SERIAL			NOT NULL,
	idlang				INT				NOT NULL,
	idmodule			INT				NOT NULL,
	namepart			VARCHAR(255)	NOT NULL,
	namefield			VARCHAR(255)	NOT NULL,
	text				VARCHAR(4000)	NOT NULL,
	CONSTRAINT	"PK-TRA_SiteTranslation-IDTra"			PRIMARY KEY	(idtra),
	CONSTRAINT	"FK-TRA_SiteTranslation-IDLang"			FOREIGN KEY	(idlang)					REFERENCES	tra_lang(idlang),
	CONSTRAINT	"FK-TRA_SiteTranslation-IDModule"		FOREIGN KEY	(idmodule)					REFERENCES	sys_module(idmodule),
	CONSTRAINT	"UK-TRA_SiteTranslation-1"				UNIQUE		(idlang, idmodule, namepart, namefield)
);