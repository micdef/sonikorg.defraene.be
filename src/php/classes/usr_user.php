<?php

	// Include Base Files
	include_once('../inc/db.inc');
	include_once('../inc/crypt.inc');
	include_once('../inc/text.inc');
	include_once('../inc/file.inc');

	class User {
		
		//********************************************************************************
		//*																				 *
		//* PART 1 : Class Members														 *
		//*																				 *
		//********************************************************************************
		private $idDB;
		private $usn;
		private $pwd;
		private $email;
		private $fname;
		private $lname;
		private $datein;
		private $factive;
		private $err;
		
		//********************************************************************************
		//*																				 *
		//* PART 2 : Static Members														 *
		//*																				 *
		//********************************************************************************
		private static $table = "usr_user";
		private static $tableVisitor = "usr_visit";
						
		//********************************************************************************
		//*																				 *
		//* PART 3 : Class Constructors													 *
		//*																				 *
		//********************************************************************************
		// Default Constructor (all to null)
		public function __construct() {
			$this->idDB = 0;
			$this->usn = null;
			$this->pwd = null;
			$this->email = null;
			$this->fname = null;
			$this->lname = null;
			$this->datein = null;
			$this->factive = null;
			$this->err = null;
		}
		
		/*! @brief By Database's Constructor
		 *  Function that construct the object using de the database
		 * 	@param[in]	$usn		The username of the user
		 * 	@param[in]	$id			The id of the database
		 */
		public function newDB($usn, $id) {
			try {
				/*if ($id == 0)
					$sql = "SELECT a.*, b.idtoken FROM " . $this->table . " AS a LEFT JOIN " . $this->tokenTable . " AS b ON (a.iduser = b.iduser AND b.action = 'CKREG') WHERE email='" . $email . "'";
				else 
					$sql = "SELECT a.*, b.idtoken FROM " . $this->table . " AS a LEFT JOIN " . $this->tokenTable . " AS b ON (a.iduser = b.iduser AND b.action = 'CKREG') WHERE a.iduser=" . $id;*/
				if ($id == 0)
					$sql = "SELECT * FROM " . $table . " WHERE usn = '" . $usn . "'";
				else
					$sql = "SELECT * FROM " . $table . " WHERE id = " . $id;
				$el = getElem($sql, $_SESSION["email"]);
				if ($el != null) {
					$this->idDB = $el["id"];
					$this->usn = $el["usn"];
					$this->pwd = $el["pwd"];
					$this->email = $el["email"];
					$this->fname = $el["fname"];
					$this->lname = $el["lname"];
					$this->datein = $el["datein"];
					$this->factive = $el["factive"];
					$this->err = null;
				}
			} catch (Exception $ex) {
				$this->idDB = -1;
				$this->usn = null;
				$this->pwd = null;
				$this->email = null;
				$this->fname = null;
				$this->lname = null;
				$this->datein = null;
				$this->factive = null;
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		
		/*! @brief By parameters' Constructor
		 *  Function that construct the object using the parameters
		 * 	@param[in]	$usn			The username of the user
		 *	@param[in]	$pwd			The password of the user
		 *  @param[in]	$email			The email of the user
		 *  @param[in]	$fname			The first name of the user
		 *  @param[in]	$lname			The last name of the user
		 *  @param[in]	$datein			The inscription date of the user
		 *  @param[in]	$factive		If the user is active or not
		 */
		public function newParam($usn, $pwd, $email, $fname, $lname, $datein, $factive) {
			$this->idDB = 0;
			$this->usn = $usn;
			$this->pwd = encrypt($pwd);
			$this->email = $email;
			$this->fname = $fname;
			$this->lname = $lname;
			$this->datein = $datein;
			$this->factive = $factive;
			$this->err = null;
		}
		
		/*! @brief Guest User's Constructor
		 *  Function that construct the object Guest User
		 */
		public function newGuest() {
			try {
				$this->idDB = 0;
				$this->usn = "guest" . time();
				$this->pwd = null;
				$this->email = "guest" . time() . "@defraene.be";
				$this->fname = "Guest";
				$this->lname = time();
				$this->datein = date("Ymd");
				$this->factive = true;
				$this->I_insertVisitor();
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		
		//********************************************************************************
		//*																				 *
		//* PART 4 : GETTERS															 *
		//*																				 *
		//********************************************************************************
		public function getDataBaseID() { return $this->idDB; }
		public function getUsername() { return $this->usn; }
		public function getEmail() { return $this->email; }
		public function getFirstName() { return $this->fname; }
		public function getLastName() { return $this->lname; }
		public function getDateIN() { return $this->datein; }
		public function isActive() { return $this->factive; }
		public function getError() { return $this->err; }
		
		//********************************************************************************
		//*																				 *
		//* PART 5 : SETTERS															 *
		//*																				 *
		//********************************************************************************
		public function setUsername($usn) {
			try {
				if ($idDB > 0) {
					if ($this->checkUsername($usn)) {
						$sql = "UPDATE " . $table . " SET usn = '" . $usn . "' WHERE id = " . $this->idDB;
						execSQL($sql, $_SESSION["email"]);
					} else {
						throw new Exception("The username you want tu use is already existing in the database.");
					}
				}
				$this->usn = $usn;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setEmail($email) {
			try {
				if (idDB > 0) {
					if (checkMail($email)) {
						$sql = "UPDATE " . $table . " SET email = '" . $email . "' WHERE id = " . $this->idDB;
						execSQL($sql, $_SESSION["email"]);
					} else {
						throw new Exception("The username you want tu use is already existing in the database.");
					}
				}
				$this->email = $email;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setPassword($pwd) {
			try {
				$pwdc = encrypt($pwd);
				if ($this->idDB > 0) {
					$sql = "UPDATE " . $table . " SET pwd = '" . $pwdc . "' WHERE id = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->pwd = $pwdc;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setFirstName($fname) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . $table . " SET fname = '" . txt2sql($fname) . "' WHERE id = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->fname = $fname;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setLastName($lname) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . $table . " SET lname = '" . txt2sql($lname) . "' WHERE id = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->lname = $lname;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setDateIN($datein) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . $table . " SET datein = '" . date('Y-m-d', strtotime($this->datein)) . "' WHERE id = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->datein = $datein;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		private function setActive($factive) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . $table . " SET factive = " . ($factive == true ? 'true' : 'false') . " WHERE id = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->factive = $factive;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		
		//********************************************************************************
		//*																				 *
		//* PART 6 : Private functions													 *
		//*																				 *
		//********************************************************************************
		private function checkMail($email) {
			$sql = "SELECT * FROM " . $table . " WHERE email = '" . $email . "'";
			return !(isElemExists($sql, $_SESSION["email"]));
		}
		
		private function checkUsername($usn) {
			$sql = "SELECT * FROM " . $table . " WHERE usn = '" . $usn . "'";
			return !(isElemExists($sql, $_SESSION["email"]));
		}
		
		//********************************************************************************
		//*																				 *
		//* PART 7 : DB Functions														 *
		//*																				 *
		//********************************************************************************
		private function dbInsert($visitor) {
			try {
				if ($this->err == null)
					if ($this->checkMail($this->email))
						if ($this->checkUsername($this->usn)) {
							$sql = "INSERT INTO " . $table . " (usn, pwd, email, fname, lname, datein, factive)";
							$sql .= "VALUES ('" . txt2sql($this->usn) . "', '" . $this->pwd & "', '" . txt2sql($this->email);
							$sql .= "', '" . txt2sql($this->fname) . "', '" . txt2sql($this-lname) . "', '";
							$sql .= date('Y-m-d', strtotime($this->datein)) . "', " . ($this->factive == true ? 'true' : 'false') . ")";
							execSQL($sql, $_SESSION["email"]);
							$sql = "SELECT id FROM " . $table . " WHERE usn = '" . $this->usn . "'";
							$this->idDB = getValue($sql, $_SESSION["email"]);
							if ($visitor == true)
								$this->dbInsertVisitor($this->idDB);
							$this->err = null;
						} else
							throw new Exception("Le nom d'utilisateur choisi est déjà utilisé.");
					else
						throw new Exception("L'email choisi est déjà utilisé");
				else
					throw new Exception("Une erreur est encore présente, veuillez la corriger svp.");
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		
		private function dbInsertVisitor() {
			try {
				$sql = "INSERT INTO " . $tableVisitor . " (iduser, datein, timein)";
				$sql .= "VALUES (" . $this->idDB . ", '" . date('Y-m-d', strtotime($this->datein));
				$sql .= "', '" . date('H:i:s', strtotime(date())) . "')";
				execSQL($sql, $_SESSION["email"]);
			} catch (Exception $ex) {
				throw $ex;
			}
		}
		
		//********************************************************************************
		//*																				 *
		//* PART 8 : Public functions													 *
		//*																				 *
		//********************************************************************************
		public function I_checkMail($email) { $this->checkMail($email); }
		public function I_checkUserName($usn) { $this->checkUsername($usn); }
		public function I_activateUser() { $this->setActive(true); }
		public function I_deactivateUser() { $this->setActive(false); }
		public function I_checkPassword($pwd) {	return (encrypt($pwd) == $this->pwd ? true : false); }
		public function I_ressetError() { $this->err = null; }
		public function I_login($pwd) {
			if ($this->pwd == encrypt($pwd) && $this->factive == true)
				return true;
			else
				return false;
		}
		public function I_insertUser() { $this->dbInsert(false); }
		public function I_insertVisitor() { $this->dbInsert(true); }
		
		//********************************************************************************
		//*																				 *
		//* PART 9 : Static functions													 *
		//*																				 *
		//********************************************************************************
		public static function I_getListOfUsers() {
			$arr = [];
			try {
				$sql = "SELECT id FROM " . $table;
				$stm = getListElem($sql, $_SESSION["email"]);
				if ($stm != null)
					if ($stm->rowCount() > 0) {
						$i = 0;
						while ($res = $stm->fetch()) {
							$user = new User();
							$user->newDB($res["id"]);
							$arr[$i++] = $user;
						}
					} else
						throw new Exception ("Pas d'enregistrement dans la base de données");
				else
					throw new Exception ("Une erreur a été constatée. Veuillez consulter le log du serveur.");
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$arr[0] = $ex->getMessage();
			} finally {
				return $arr;
			}
		}
		
		//********************************************************************************
		//*																				 *
		//* PART 10 : Override functions												 *
		//*																				 *
		//********************************************************************************
		public function equals($user) {
			if ($this->idDB == $user->getDataBaseID() && $this->usn == $user->getUsername() && $this->email = $user->getEmail() &&
				$this->fname == $user->getFirstName() && $this->lname == $user->getLastName() && $this->datein == $user->getDateIN() &&
				$this->factive == $user->isActive())
				return true;
			else
				return false;
		}
	}

?>