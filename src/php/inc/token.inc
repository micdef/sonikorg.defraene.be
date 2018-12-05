<?php
	
	//******************************************************************************
    //*                                                                            *
    //* PARTIE 1 : FICHIERS A INCLURE                                              *
    //*                                                                            *
    //******************************************************************************
    include_once 'db.inc';
	include_once 'crypt.inc';
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 2 : DECLARATION DES VARIABLES GLOBALES                              *
    //*                                                                            *
    //******************************************************************************
    global $tableToken;
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 3 : MISE EN PLACE DES VALEURS DES VARIABLES GLOBALES                *
    //*                                                                            *
    //******************************************************************************
    $tableToken = "usr_token";
	    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 4 : FONCTIONS                                                       *
    //*                                                                            *
    //******************************************************************************
	/*! @brief Fonction qui crée un token
	 *  Cette fonction crée un token que ce soit pour l'enregistrement, le login, ...
	 *  @param[in]	$user			L'utilisateur auquel est associé le token
	 *	@param[in]	$action			L'action que le token engendre
	 *	@param[in]	$param			Les paramètres qui définissent l'action
	 *	@param[in]	$time			Le temps de validité restant pour le token
	 */
	function createToken($user, $action, $param, $time) {
		global $tableToken;
		try {
			$id = $user->getDataBaseID() + time();
			$valid = $time;
			if (isElemExists("SELECT * FROM " . $tableToken . " WHERE iduser=" . $user->getDataBaseID() . " AND action='" . $action . "'", $_SESSION["user"])) {
				$sql = "DELETE FROM " . $tableToken . " WHERE iduser=" . $user->getDataBaseID() . " AND action='" . $action . "'";
				execSQL($sql, $_SESSION["email"]);
			}
			$sql = "INSERT INTO " . $tableToken . " (hashtoken, iduser, timevalid, action, param) VALUES ('" . encrypID($id) . "', " . $user->getDataBaseID() . ", ";
			$sql .= $valid . ", '" . $action . "', '" . $param . "')";
			execSQL($sql, $_SESSION["email"]);
		} catch (Exception $ex) {
			writeError($_SESSION["email"] . " - " . $ex->getMessage());
		}
	}

	/*! @brief Fonction qui supprime un token
	 *	Cette fonction supprime un token de la base de données par rapport à son ID
	 *	@param[in]	$idToken		L'identifiant unique du token à supprimer
	 */
	function deleteToken($idToken) {
		global $tableToken;
		try {
			$sql = "DELETE FROM " . $tableToken . " WHERE hashtoken = '" . $idToken . "'";
			execSQL($sql, $_SESSION["email"]);
		} catch (Exception $ex) {
			writeError($_SESSION["email"] . " - " . $ex->getMessage());
		}
	}

	/*!	@brief Fonction qui vérifie la validité d'un token
	 *	Cette fonction vérifie qu'un token est toujours dans sa période de grâce
	 *	@param[in]	$idtoken		L'identifiant unique du token à supprimer
	 *	@param[in]	$action			L'action qu'entreprend le token
	 *	@return		True			Si le token est toujours dans sa période de grâce
	 *				False			Si le token n'est plus dans sa période de grâce
	 *				Null			Si une erreur s'est produite
	 */
	function checkToken($idtoken, $action) {
		global $tableToken;
		try {
			$sql = "SELECT * FROM " . $tableToken . " WHERE hashtoken = '" . $idtoken . "' AND action = '" . $action . "'";
			if (isElemExists($sql, $_SESSION["email"])) {
				$el = getElem($sql, $_SESSION["email"]);
				if ($el["timevalid"] >= time())
					return true;
				else 
					return false;
			} else
				return false;
		} catch (Exception $ex) {
			writeError($_SESSION["email"] . " - " . $ex->getMessage());
			return null;
		}
	}
	
	/*!	@brief Fonction de MAJ d'un token
	 *	Cette fonction met à jour le temps de validité d'un token.
	 *	@param[in]	$idtoken		L'identifiant unique du token à mettre à jour
	 *	@param[in]	$time			Le temps de validité mis à jour
	 */
	function updateToken($idtoken, $time) {
		global $tableToken;
		try {
			$sql = "UPDATE " . $tableToken . " SET timevalid = " . $time . " WHERE hashtoken = '" . $idtoken . "'";
			execSQL($sql, $_SESSION["email"]);
		} catch (Exception $ex) {
			writeError($_SESSION["email"] . " - " . $ex->getMessage());
		}
	}
	
	/*! @brief Fonction de récupération d'un token
	 *	Cette fonction récupère un token via son identifiant unique
	 *	@param[in]	$idtoken		L'identifiant unique du token à récupérer
	 *	@return		$token			L'enregistrement que retourne la DB (cela peut être 0 lignes)
	 *				null			Si il y a eu une erreur
	 */
	function getToken($idtoken) {
		global $tableToken;
		try {
			$sql = "SELECT * FROM " . $tableToken . " WHERE hashtoken = '" . $idtoken . "'";
			$token = getElem($sql, $_SESSION["email"]);
			return $token;
		} catch (Exception $ex) {
			writeError($_SESSION["email"] . " - " . $ex->getMessage());
			return null;
		}
	}
	
	/*!	@brief	Fonction de récupération de l'ID d'un token
	 *	Cette fonction va en base de données récupérer l'identifiant d'un token selon son action et son utilisateur
	 *	@param[in]	$action			L'action qu'entreprend le token
	 *	@param[in]	$user			L'utilisateur associé au token
	 *	@return		$value			La valeur retrouvée (peut être nulle si pas de ligne dans la DB)
	 *				null			si il y a eu une erreur
	 */
	function getIDToken($action, $user) {
		global $tableToken;
		try {
			$sql = "SELECT hashtoken FROM " . $tableToken . " WHERE action ='" . $action . "' AND iduser = " . $user->getDataBaseID();
			return getValue($sql, $_SESSION["email"]);
		} catch (Exception $ex) {
			writeError($_SESSION["email"] . " - " . $ex->getMessage());
			return null;
		}
	}
	
	/*!	@brief Récupère tout les tokens présents dans la table usr_token
	 *	Cette fonction va récupérer tout les tokens prensents dans la table usr_token et les renvoie sous forme de tableau
	 *	@return		$arr			Tableau contenant les tokens ou l'erreur
	 */
	function getListToken() {
		global $tableToken;
		try {
			$arr = [];
			$sql = "SELECT hashtoken FROM " . $tableToken . "";
			$stm = getListElem($sql, $_SESSION["email"]);
			if ($stm != null)
				if ($stm->rowCount() > 0) {
					$i = 0;
					while ($res = $stm->fetch()) {
						$token = getToken($res["idtoken"]);
						$arr[$i++] = $token;
					}
				} else
					throw new Exception("No rows found in the DB");
			else 
				throw new Exception("An error has occured. Please read the log.");
		} catch (Exception $ex) {
			writeError($_SESSION["email"] . " - " . $ex->getMessage());
			$arr[0] = $ex->getMessage();
		} finally {
			return $arr;
		}
	}
	
	/*!	@brief Met à jour le token de session
	 *	Cette fonction met à jour le token de session pour chaque action (compteur sur une heure pour l'idle)
	 *	@param[in]		$idtoken		L'identifiant unique du token
	 */
	function updateSessionToken($idtoken) {
		if (checkToken($idtoken, "CKLOG") && $idtoken != 0)
			updateToken($idtoken, (time() + 3600));
	}

?>