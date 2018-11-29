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
    global $cryptKey;
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 3 : MISE EN PLACE DES VALEURS DES VARIABLES GLOBALES                *
    //*                                                                            *
    //******************************************************************************
    $cryptKey = 'k01D3fR43n3snkCuPZ18BE';
    
    //******************************************************************************
    //*                                                                            *
    //* PARTIE 4 : FONCTIONS                                                       *
    //*                                                                            *
    //******************************************************************************
	/*! @brief Cryptage des données sensibles
     *  Cette fonction crypte les données sensible, ce cryptage est irréversible
     *  @param[in]  $s              Ce qu'il faut crypter
     *  @return     $qEncoded       L'élement crypté
     *  @throw      Toute exception générée pendant le cryptage
     */
    function encrypt($s) {
        global $cryptKey;
        try {
            $qEncoded = hash("sha512", $cryptKey . $s);
            return $qEncoded;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /*! @brief Cryptage des liens
     *  Cette fonction crypte les liens web envoyés par email. Ce cryptage est réversible
     *  @param[in]  $s              Le lien à crypter
     *  @return     $str            Le lien crypté
     *  @throw      Toute exception générée pendant le cryptage 
     */
    function lightEncrypt($s) {
        try {
            $str = "";
            for ($i = 0; $i < strlen($s); $i++) {
                $nb = ord(substr($s, $i, 1));
                $car = "";
                if ($nb < 10)
                    $car = "00" . $nb;
                elseif ($nb < 100)
                    $car = "0" . $nb;
                else
                    $car = $nb;
                $str .= $car;
            }
            return $str;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /*! @brief Décryptage des liens
     *  Cette fonction décrypte les liens web envoyés par email. Ce cryptage est réversible
     *  @param[in]  $s              Le lien à décrypter
     *  @return     $str            Le lien décrypté
     *  @throw      Toute exception générée pendant le déryptage
     */
    function ligthDecrypt($s) {
        try {
            $str = "";
            for ($i = 0; $i < strlen($s); $i = $i+3)
                $str .= chr(substr($s, $i, 3));
            return $str;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
?>