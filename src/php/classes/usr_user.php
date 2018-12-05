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
		private $username;
		private $password;
		private $firstname;
		private $lastname;
		private $gender;
		private $datein;
		private $email;
		private $tel;
		private $flagactive;
		private $flagdelete;
		private $err;
		
		//********************************************************************************
		//*																				 *
		//* PART 2 : Static Members														 *
		//*																				 *
		//********************************************************************************
		private static $table = "usr_user";
		private static $tableVisitor = "usr_visit";
		private static $tableToken = "usr_token";
						
		//********************************************************************************
		//*																				 *
		//* PART 3 : Class Constructors													 *
		//*																				 *
		//********************************************************************************
		// Default Constructor (all to null)
		public function __construct() {
			$this->idDB = 0;
			$this->username = null;
			$this->password = null;
			$this->firstname = null;
			$this->lastname = null;
			$this->gender = null;
			$this->datein = null;
			$this->email = null;
			$this->tel = null;
			$this->flagactive = false;
			$this->flagdelete = false;
			$this->err = null;
		}
		
		/*! @brief By Database's Constructor
		 *  Function that construct the object using de the database
		 * 	@param[in]	$usn		The username of the user
		 * 	@param[in]	$id			The id of the database
		 */
		public function newDB($usn, $id) {
			try {
				if ($id == 0)
					$sql = "SELECT a.*, b.idtoken FROM " . User::$table . " AS a LEFT JOIN " . User::$tableToken . " AS b ON (a.iduser = b.iduser AND b.action = 'CKREG') WHERE email='" . $email . "'";
				else 
					$sql = "SELECT a.*, b.idtoken FROM " . User::$table . " AS a LEFT JOIN " . User::$tableToken . " AS b ON (a.iduser = b.iduser AND b.action = 'CKREG') WHERE a.iduser=" . $id;
				$el = getElem($sql, $_SESSION["email"]);
				if ($el != null) {
					$this->idDB = $el["iduser"];
					$this->username = $el["username"];
					$this->password = $el["password"];
					$this->firstname = $el["firstname"];
					$this->lastname = $el["lastname"];
					$this->gender = $el["gender"];
					$this->datein = $el["datein"];
					$this->email = $el["email"];
					$this->tel = $el["tel"];
					$this->flagactive = $el["flagactive"];
					$this->flagdelete = $el["flagdelete"];
					$this->err = null;
				}
			} catch (Exception $ex) {
				$this->idDB = -1;
				$this->username = null;
				$this->password = null;
				$this->firstname = null;
				$this->lastname = null;
				$this->gender = null;
				$this->datein = null;
				$this->email = null;
				$this->tel = null;
				$this->flagactive = false;
				$this->flagdelete = false;
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
		public function newParam($usn, $pwd, $fname, $lname, $gender, $datein, $email, $tel, $factive, $fdelete) {
			$this->idDB = 0;
			$this->username = $usn;
			$this->password = encrypt($pwd);
			$this->firstname = $fname;
			$this->lastname = $lname;
			$this->gender = $gender;
			$this->datein = $datein;
			$this->email = $email;
			$this->tel = $tel;
			$this->flagactive = $factive;
			$this->flagdelete = $fdelete;
			$this->err = null;
		}
		
		/*! @brief Guest User's Constructor
		 *  Function that construct the object Guest User
		 */
		public function newGuest() {
			try {
				$this->idDB = 0;
				$this->username = "guest" . time();
				$this->password = null;
				$this->firstname = "Guest";
				$this->lastname = time();
				$this->gender = "M";
				$this->datein = date("Ymd");
				$this->email = "guest" . time() . "@defraene.be";
				$this->tel = null;
				$this->flagactive = true;
				$this->flagdelete = false;
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
		public function getUsername() { return $this->username; }
		public function getFirstname() { return $this->firstname; }
		public function getLastname() { return $this->lastname; }
		public function getGender() { return $this->gender; }
		public function getDateIN() { return $this->datein; }
		public function getEmail() { return $this->email; }
		public function getTelephone() { return $this->tel; }
		public function isActive() { return $this->flagactive; }
		public function isDeleted() { return $this->flagdelete; }
		public function getError() { return $this->err; }
		
		//********************************************************************************
		//*																				 *
		//* PART 5 : SETTERS															 *
		//*																				 *
		//********************************************************************************
		public function setUsername($usn) {
			try {
				if ($this->idDB > 0 && $this->checkUsername($usn)) {
					$sql = "UPDATE " . User::$table . " SET username = '" . txt2sql($usn) . "' WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
					$this->username = $usn;
				} elseif ($this->idDB > 0 && !$this->checkUsername($usn))
					throw new Exception("The username you want to use is already existing in the DB");
				else
					$this->username = $usn;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setFirstname($fname) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . User::$table . " SET firstname = '" . txt2sql($fname) . "' WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->firstname = $fname;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setLastname($lname) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . User::$table . " SET lastname = '" . txt2sql($lname) . "' WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->lastname = $lname;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setGender($gender) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . User::$table . " SET gender = '" . txt2sql($gender) . "' WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->gender = $gender;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setDateIN($datein) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . User::$table . " SET datein = '" . date('Y-m-d', strtotime($this->datein)) . "' WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->datein = $datein;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setEmail($email) {
			try {
				if ($this->idDB > 0 && $this->checkMail($email)) {
					$sql = "UPDATE " . User::$table . " SET email = '" . txt2sql($email) . "' WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
					$this->email = $email;
				} elseif ($this->idDB > 0 && !$this->checkMail($email))
					throw new Exception("The email you want to use is already existing in the DB");
				else
					$this->email = $email;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		public function setTelephone($tel) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . User::$table . " SET tel = '" . txt2sql($tel) . "' WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->tel = $tel;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		private function setActive($factive) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . User::$table . " SET flagactive = " . ($factive ? "true" : "false") . " WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->flagactive = $factive;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		private function setDeleted($fdelete) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . User::$table . " SET flagdelete = " . ($fdelete ? "true" : "false") . " WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->flagdelete = $fdelete;
				$this->err = null;
			} catch (Exception $ex) {
				writeError(date('Y-m-d') . ' - ' . $ex->getMessage());
				$this->err = $ex->getMessage();
			}
		}
		private function setPassword($pwd) {
			try {
				if ($this->idDB > 0) {
					$sql = "UPDATE " . User::$table . " SET password = '" . encrypt($pwd) . "' WHERE iduser = " . $this->idDB;
					execSQL($sql, $_SESSION["email"]);
				}
				$this->password = encrypt($pwd);
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
				if ($this->err = null)
					if ($this->checkMail($this->email))
						if ($this->checkUsername($this->username)) {
							$sql = "INSERT INTO " . User::$table . " (username, password, firstname, lastname, gender, datein, email, tel, flagactive, flagdelete) ";
							$sql .= "VALUES ('" . txt2sql($this->usn) . "', '" . $this->pwd . "', '" . txt2sql($this->firstname) . "', '" . txt2sql($this->lastname);
							$sql .= "', '" . txt2sql($this->gender) . "', '" . date('Y-m-d', strtotime($this->datein)) . "', '" . txt2sql($this->email) . "', '";
							$sql .= txt2sql($this->tel) . "', " . ($this->flagactive ? "true" : "false") . ", " . ($this->flagdelete ? "true" : "false") . ")";
							execSQL($sql, $_SESSION["email"]);
							$sql = "SELECT iduser FROM " . User::$table . " WHERE username = '" . txt2sql($this->usn) . "'";
							$this->idDB = getValue($sql, $_SESSION["email"]);
							if ($visitor)
								dbInsertVisitor();
							$this->err = null;
						} else
							throw new Exception("The username you want to use is already existing in the DB.");
					else
						throw new Exception("The email you want to use is already existing in the DB.");
				else
					throw new Exception("An error occures in the system. Please correct it and try again.");
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
		public function I_deleteUser() { $this->setDeleted(true); }
		public function I_undeleteUser() { $this->setDeleted(false); }
		public function I_checkPassword($pwd) {	return (encrypt($pwd) == $this->pwd ? true : false); }
		public function I_changePassword($pwd) { $this->setPassword($pwd); }
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
			if ($this->username == $user->username && $this->firstname == $user->firstname && $this->lastname == $user->lastname &&
				$this->gender == $user->gender && $this->datein == $user-datein && $this->email == $user->email && $this->tel == $user->tel)
				return true;
			else
				return false;
		}
	}

?>