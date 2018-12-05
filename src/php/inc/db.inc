<?php
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 1 : FICHIERS A INCLURE                                              *
    //*                                                                            *
    //******************************************************************************
    include_once 'file.inc';
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 2 : DECLARATION DES VARIABLES GLOBALES                              *
    //*                                                                            *
    //******************************************************************************
    global $strConn;
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 3 : MISE EN PLACE DES VALEURS DES VARIABLES GLOBALES                *
    //*                                                                            *
    //******************************************************************************
    $strConn = "pgsql:host=private.defraene.be;port=5432;dbname=sonikorg.defraene.be;user=postgres;password=S0n1C'1984!M1Cd";
	    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 4 : FONCTIONS                                                       *
    //*                                                                            *
    //******************************************************************************
    /*! @brief Exécution d'une commande SQL
     *  Cette fonction exécute une commande SQL
     *  @param[in]  $sql            La commande SQL à exécuter
     *  @param[in]  $email          L'email de l'utilisateur qui exécute la commande
     *  @throw      Toute exception générée par le système PDO
     */
    function execSQL($sql, $email) {
        global $strConn;
        try {
            $dbh = new PDO($strConn);
            $stm = $dbh->prepare($sql);
            if (!$stm->execute()) {
                throw new Exception($email . " - " . $stm->errorInfo()[0] . " - " . $stm->errorInfo()[1] . " - " . $stm->errorInfo()[2]);
            } else {
                writeSQL($email . " - " . $sql);
            }
        } catch (Exception $ex) {
            writeError($email . " - " . $ex->getMessage());
            throw $ex;
        }
    }
    
    /*! @brief Vérification qu'un élément existe dans la DB
     *  Cette fonction check en base de données si l'élément existe.
     *  @param[in]  $sql            La commande SQL à exécuter
     *  @param[in]  $email          L'email de l'utilisateur qui exécute la commande
     *  @return     True            Vrai si l'élément existe
     *              False           Faux si l'élément n'existe pas
     *  @throw      Toute exception générée par le système PDO 
     */
    function isElemExists($sql, $email) {
        global $strConn;
        try {
            $dbh = new PDO($strConn);
            $stm = $dbh->prepare($sql);
            if (!$stm->execute()) {
                throw new Exception($email . " - " . $stm->errorInfo()[0] . " - " . $stm->errorInfo()[1] . " - " . $stm->errorInfo()[2]);
            } else {
                if ($stm->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $ex) {
            writeError($email . " - " . $ex->getMessage());
            throw $ex;
        }
    }
    
    /*! @brief Vérifie le nombre d'élément dans la base de données
     *  Cette fonction exécute une requête SQL et vérifie le nombre d'éléments retournés
     *  @param[in]  $sql            La commande SQL à exécuter
     *  @param[in]  $email          L'email de l'utilisateur qui exécute la commande
     *  @return     $stm->rowCount  Le nombre de lignes retournées par la requête
     *  @throw      Toute exception générée par le système PDO
     */
    function getNbElem($sql, $email) {
        global $strConn;
        try {
            $dbh = new PDO($strConn);
            $stm = $dbh->prepare($sql);
            if (!$stm->execute()) {
                throw new Exception($email . " - " . $stm->errorInfo()[0] . " - " . $stm->errorInfo()[1] . " - " . $stm->errorInfo()[2]);
            } else {
                return $stm->rowCount();
            }
        } catch (Exception $ex) {
            writeError($email . " - " . $ex->getMessage());
            throw $ex;
        }
    }
    
    /*! @brief Retrouve un élément dans la base de données
     *  Cette fonction exécute une requête SQL et retourne le premier élément retrouvé.
     *  @param[in]  $sql            La commande SQL à exécuter
     *  @param[in]  $email          L'email de l'utilisateur qui exécute la commande
     *  @return     $stm->fetch     Le premier élément de la liste
     *  @throw      Toute exception générée par le système PDO
     */
    function getElem($sql, $email) {
        global $strConn;
        try {
            $dbh = new PDO($strConn);
            $stm = $dbh->prepare($sql);
            if (!$stm->execute()) {
                throw new Exception($email . " - " . $stm->errorInfo()[0] . " - " . $stm->errorInfo()[1] . " - " . $stm->errorInfo()[2]);
            } else {
                return $stm->fetch();
            }
        } catch (Exception $ex) {
            writeError($email . " - " . $ex->getMessage());
            throw $ex;
        }
    }
    
    /*! @brief Retrouve des éléments dans la base de données
     *  Cette fonction exécute une requête SQL et retourne la liste des éléments retrouvé.
     *  @param[in]  $sql            La commande SQL à exécuter
     *  @param[in]  $email          L'email de l'utilisateur qui exécute la commande
     *  @return     $stm            La liste des éléments retrouvés.
     *  @throw      Toute exception générée par le système PDO
     */
    function getListElem($sql, $email) {
        global $strConn;
        try {
            $dbh = new PDO($strConn);
            $stm = $dbh->prepare($sql);
            if (!$stm->execute()) {
                throw new Exception($email . " - " . $stm->errorInfo()[0] . " - " . $stm->errorInfo()[1] . " - " . $stm->errorInfo()[2]);
            } else {
                return $stm;
            }
        } catch (Exception $ex) {
            writeError($email . " - " . $ex->getMessage());
            throw $ex;
        }
    }
    
    /*! @brief Retourne la valeur de la première colonne du premier élément retrouvé par rapport une requête SQL
     *  Cette fonction qui exécute une requête SQL et retourne la valeur de la première colonne du premier élément.
     *  @param[in]  $sql            La commande SQL à exécuter
     *  @param[in]  $email          L'email de l'utilisateur qui exécute la commande
     *  @return     $res[0]         La valeur de la première colonne du premier élément
     *  @throw      Toute exception générée par le système PDO
     */
    function getValue($sql, $email) {
        global $strConn;
        try {
            $dbh = new PDO($strConn);
            $stm = $dbh->prepare($sql);
            if (!$stm->execute()) {
                throw new Exception($email . " - " . $stm->errorInfo()[0] . " - " . $stm->errorInfo()[1] . " - " . $stm->errorInfo()[2]);
            } else {
                $res = $stm->fetch();
                return $res[0];
            }
        } catch (Exception $ex) {
            writeError($email . " - " . $ex->getMessage());
            throw $ex;
        }
    }

?>