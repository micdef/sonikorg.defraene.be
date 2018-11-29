<?php
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 1 : FICHIERS A INCLURE                                              *
    //*                                                                            *
    //******************************************************************************
    // N/A
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 2 : DECLARATION DES VARIABLES GLOBALES                              *
    //*                                                                            *
    //******************************************************************************
    global $fichDir;
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 3 : MISE EN PLACE DES VALEURS DES VARIABLES GLOBALES                *
    //*                                                                            *
    //******************************************************************************
    $fichDir = 'C:\\xampp\\htdocs\\SonikOrgServices\\home\\web\\logs\\' & date("Ymd");
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 4 : FONCTIONS                                                       *
    //*                                                                            *
    //******************************************************************************
    /*! @brief Ecriture de l'erreur
     *  Fonction qui écrit l'erreur dans le fichier correspondant
     *  @param[in]  $str        Texte de l'erreur
     */
    function writeError($str) {
        global $fichDir;
        createRep();
        $fich = fopen($fichDir . '\\' . date("H") . '-err.log', 'a+');
        fputs($fich, date("H:i:s ==> "));
        fputs($fich, $str . "\n");
        fclose($fich);
    }
    
    /*! @brief Ecriture de la requête SQL
     *  Fonction qui écrit les requêtes SQL dans le fichier correspondant
     *  @param[in]  $str        Requête SQL exécutée
     */
    function writeSQL($str) {
        global $fichDir;
        createRep();
        $fich = fopen($fichDir . '\\' . date("H") . '-sql.log', 'a+');
        fputs($fich, date("H:i:s ==> "));
        fputs($fich, $str . "\n");
        fclose($fich);
    }
    
    /*! @brief Création du répertoire
     *  Fonction qui crée le répertoire nécessaire pour le stockage des fichiers. 
     */
    function createRep() {
        global $fichDir;
        if (!file_exists($fichDir))
            mkdir($fichDir, 1777);
        if (!file_exists($fichDir . '\\' . date("H") . '-err.log')) {
            $fich = fopen($fichDir . '\\' . date("H") . '-err.log', 'x');
            fclose($fich);
        }
        if (!file_exists($fichDir . '\\' . date("H") . '-sql.log')) {
            $fich = fopen($fichDir . '\\' . date("H") . '-sql.log', 'x');
            fclose($fich);
        }
    }
?>