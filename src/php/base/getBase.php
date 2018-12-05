<?php

	//******************************************************************************
    //*                                                                            *
    //* PARTIE 0 : HEADERS PHP		                                               *
    //*                                                                            *
    //******************************************************************************
	header('Content-type: text/xml; charset=UTF-8');

	//******************************************************************************
    //*                                                                            *
    //* PARTIE 1 : FICHIERS A INCLURE                                              *
    //*                                                                            *
    //******************************************************************************
    include_once '../inc/db.inc';
	include_once '../inc/file.inc';

	//******************************************************************************
    //*                                                                            *
    //* PARTIE 2 : DECLARATION DES VARIABLES GLOBALES                              *
    //*                                                                            *
    //******************************************************************************
	// N/A

	//******************************************************************************
    //*                                                                            *
    //* PARTIE 3 : MISE EN PLACE DES VALEURS DES VARIABLES GLOBALES                *
    //*                                                                            *
    //******************************************************************************
	// N/A
	
	//******************************************************************************
    //*                                                                            *
    //* PARTIE 4 : EXECUTION DU RPC                								   *
    //*                                                                            *
    //******************************************************************************
	try {
		
		// Mise en place de la session
		$session = $_GET["session"];
		if ($session == null) throw new Exception("No Session ID");
		session_id($session);
		session_start();
		
		// Préparation des requêtes sql
		$sql_menu = "SELECT nodecurr.code AS curr_code,
							nodecurr.fa_icon AS curr_faicon,
							nodecurr.file_icon AS curr_fileicon,
							(SELECT tra_dbtranslation.text 
							 FROM tra_lang 
							 	INNER JOIN tra_dbtranslation USING (idlang) 
							 WHERE tra_lang.code = '" . $_SESSION["lang"] . "' AND tra_dbtranslation.valueunique = nodecurr.code) AS curr_translation,
							node.listorder AS curr_listorder,
							nodeprev.code AS prev_code,
							nodeprev.fa_icon AS prev_faicon,
							nodeprev.file_icon as prev_fileicon,
							(SELECT tra_dbtranslation.text 
							 FROM tra_lang 
							 	INNER JOIN tra_dbtranslation USING (idlang) 
							 WHERE tra_lang.code = '" . $_SESSION["lang"] . "' AND tra_dbtranslation.valueunique = nodeprev.code) AS prev_translation,
							nodenext.code AS next_code,
							nodenext.fa_icon AS next_faicon,
							nodenext.file_icon AS next_fileicon,
							(SELECT tra_dbtranslation.text 
							 FROM tra_lang 
							 	INNER JOIN tra_dbtranslation USING (idlang) 
							 WHERE tra_lang.code = '" . $_SESSION["lang"] . "' AND tra_dbtranslation.valueunique = nodenext.code) AS next_translation,
							(SELECT tra_dbtranslation.text 
							 FROM tra_lang 
							 	INNER JOIN tra_dbtranslation USING (idlang) 
							 WHERE tra_lang.code = '" . $_SESSION["lang"] . "' AND tra_dbtranslation.valueunique = category.code) AS cate_translation

					 FROM sys_node AS node
						INNER JOIN sys_nodeitem AS nodecurr ON node.idnodecurr = nodecurr.idnodeitem
						INNER JOIN sys_category AS category ON nodecurr.idcategory = category.idcategory
						LEFT JOIN sys_nodeitem AS nodeprev ON node.idnodeprev = nodeprev.idnodeitem
						LEFT JOIN sys_nodeitem AS nodenext ON node.idnodenext = nodenext.idnodeitem
	
					 WHERE nodecurr.flagmaintenance = false
						AND nodecurr.flagactive = true
						AND category.flagmaintenance = false
						AND category.flagactive = true
	
					 ORDER BY 	category.listorder ASC,
								node.listorder ASC";
		$sql_lang = "SELECT 	(SELECT tra_dbtranslation.text 
								 FROM tra_lang 
								 	INNER JOIN tra_dbtranslation USING (idlang) 
								 WHERE tra_lang.code = 'fr-fr' AND tra_dbtranslation.valueunique = lang.code) AS langname,
								lang.code AS langcode

					 FROM tra_lang AS lang

					 ORDER BY langname asc";
		$sql_category = "SELECT dbtranslation.text AS name,
								category.fa_icon AS faicon,
								category.file_icon as fileicon,
								category.listorder as listorder

						 FROM sys_category AS category
							INNER JOIN tra_dbtranslation AS dbtranslation ON category.code = dbtranslation.valueunique
							INNER JOIN tra_lang AS lang USING (idlang)

						 WHERE lang.code = '" . $_SESSION["lang"] . "'

						 ORDER BY listorder ASC";
		
		// Exécution des requêtes sql
		$elMenu = getListElem($sql_menu, $_SESSION["email"]);
		$elLang = getListElem($sql_lang, $_SESSION["email"]);
		$elcategory = getListElem($sql_category, $_SESSION["email"]);
		
		// Mise en place du XML
		$xml = "<?xml version=\"1.0\" ?>
				<sonikorg.defraene.be>";
		
		// Mise en place des categories
		$i = 0;
		while ($res = $elcategory->fetch()) {
			$xml .= "<category><name>" . $res["name"] . "</name><faicon>" . $res["faicon"] . "</faicon><fileicon>" . $res["fileicon"] . "</fileicon><listorder>" . $res["listorder"] . "</listorder></category>";
		}
		
		// Mise en place du menu
		$i = 0;
		while ($res = $elMenu->fetch()) {
			$xml .= "<menuitem><categoryname>" . ($res["cate_translation"] == null ? 0 : $res["cate_translation"])  . "</categoryname><nodecurr><name>" . ($res["curr_translation"] == null ? 0 : $res["curr_translation"]) . "</name><code>" . ($res["curr_code"] == null ? 0 : $res["curr_code"]) . "</code><faicon>" . ($res["curr_faicon"] == null ? 0 : $res["curr_faicon"]) . "</faicon><fileicon>" . ($res["curr_fileicon"] == null ? 0 : $res["curr_fileicon"]) . "</fileicon></nodecurr><nodeprev><name>" . ($res["prev_translation"] == null ? 0 : $res["prev_translation"]) . "</name><code>" . ($res["prev_code"] == null ? 0 : $res["prev_code"]) . "</code><faicon>" . ($res["prev_faicon"] == null ? 0 : $res["prev_faicon"]) . "</faicon><fileicon>" . ($res["prev_fileicon"] == null ? 0 : $res["prev_fileicon"]) . "</fileicon></nodeprev><nodenext><name>" . ($res["next_translation"] == null ? 0 : $res["next_translation"]) . "</name><code>" . ($res["next_code"] == null ? 0 : $res["next_code"]) . "</code><faicon>" . ($res["next_faicon"] == null ? 0 : $res["next_faicon"]) . "</faicon><fileicon>" . ($res["next_fileicon"] == null ? 0 : $res["next_fileicon"]) . "</fileicon></nodenext></menuitem>";
			$i++;
		}
		
		// Mise en place des langues
		$i = 0;
		while ($res = $elLang->fetch()) {
			$xml .= "<lang><name>" . $res["langname"] . "</name><code>" . $res["langcode"] . "</code></lang>";
		}
		
	} catch (Exception $ex) {
		
		// Préparation du XML
		$xml = "<?xml version=\"1.0\" ?>
				<sonikorg.defraene.be>
					<error><code>500</code><msg>" . $ex->getMessage() . "</msg></error>
				";
		writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
		
	} finally {
		
		// Finalisation du XML
		$xml .= "</sonikorg.defraene.be>";
		
		// Retour du RPC
		echo $xml;
	}

?>