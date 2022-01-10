<?php

require_once 'model/UtilisateurModel.php';

class Utilisateur extends Utilisateur_model
{

    private $_login;
    private $_mdp;
    private $_mdp2;
    private $_id;
    public $_Malert;

    function __construct($login, $mdp, $mdp2)
    {
        $this->_login = $login;
        $this->_mdp = $mdp;
        $this->_mdp2 = $mdp2;
    }

    public function alerte()
    {
        return $this->_Malert;
    }

    private function verifmdp2()
    {
        if ($this->_mdp == $this->_mdp2) {
            if ($this->_mdp == "") {
                $this->_Malert = 'Votre mot de passe ne peut-être vide';
                $this->_Talert = 0;
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $this->_Malert = 'Le mot de passe de correspond pas';
            $this->_Talert = 0;
            return FALSE;
        }
    }

    private function verif_exist_util()
    {
        // $this->_Malert = $this->req_UtilParLogin($this->_login) ? "L'utilisateur ".$this->_login." existe déjà" : "";
        // $this->_Talert = 0;
        // return $this->req_UtilParLogin($this->_login);
        if ($this->req_UtilParLogin($this->_login) != NULL) {
            $this->_Malert = $this->req_UtilParLogin($this->_login) ? "L'utilisateur " . $this->_login . " existe déjà" : "";
            $this->_Talert = 0;
            return TRUE;
        } elseif ($this->req_UtilParLogin($this->_login) == NULL) {
            return FALSE;
        }
    }

    public function inscription_utilisateur()
    {
        if ($this->verifmdp2() && $this->verif_exist_util() == FALSE) {
            $this->ins_util($this->_login, $this->_mdp);
            $_SESSION['login'] = $this->_login;
            $this->_Malert = 'Votre compte a été crée, ' . $this->_login . ', vous allez être redirigé...';
            $this->_Talert = 1;
            header("Refresh: 2;url='/connect'");
        } 
    }
    
    public function connexion_utilisateur()
    {
        $util = $this->req_UtilParLogin($this->_login);
            if($util == NULL){
                $this->_Malert = "L'utilisateur n'existe pas";
                $this->_Talert = 0;
                return;
            }
        $this->_mdp2 = $util[0]['password'];
        if ($this->verifmdp2()) {
            $this->_Malert = "Bienvenue ".$this->_login;
            $this->_Talert = 1;
            $_SESSION['login'] = $this->_login;
            $_SESSION['id'] = $util[0]['id'];
            header("Refresh: 2;url='/'");
        }
        
        
    }
}
