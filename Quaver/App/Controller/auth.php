<?php
/*
 * Copyright (c) 2014 Alberto González
 * Distributed under MIT License
 * (see README for details)
 */

namespace Quaver\App\Controller;

use Quaver\Core\Controller;
use Quaver\App\Model\User;
use Quaver\App\Model\Functions;

/**
 * Auth controller
 * @package App
 */
class auth extends Controller
{

    /**
     * User login
     * @return type
     */
    public function loginAction()
    {
        global $_user, $_lang;

        if ($_user->logged){
            header("Location: /");
            exit;
        }

        // REF
        $goTo = '/';
        if (!empty($_REQUEST['ref'])) {
            $goTo = preg_match('/^([a-zA-Z0-9-_]+)$/', $_REQUEST['ref'])? "/${_REQUEST['ref']}/" : $_REQUEST['ref'];
        } else if (!empty($_SERVER['HTTP_REFERER'])) {
            $goTo = $_SERVER['HTTP_REFERER'];
        }

        //Sanatize the url (CR LF Header location Attacks and external urls)
        $goTo = parse_url($goTo, PHP_URL_PATH);
        $goTo = $goTo? $goTo : '/';

        //Login action
        if (isset($_POST['email']) && isset($_POST['password'])
            && !empty($_POST['email']) && !empty($_POST['password'])) {

            $user = new User;
            if ($user->getFromEmailPassword($_POST['email'], $_POST['password']) > 0) {
                if ($user->isActive()) {
                    // Logged in
                    $user->setCookie();
                    
                    unset($_SESSION["logged"]); 
                    unset($_SESSION["uID"]);
                    session_destroy();
                    
                    if (empty($user->language)) {
                        $user->language = $_lang->id;
                        $user->save();
                    } else {
                        $_lang->getFromId($user->language);
                        $_lang->setCookie();
                    }
                    
                } else {
                    // User not active
                    $goTo = '/login/?user-disabled';
                }
            } else {
                // Error logging in
                $goTo = '/login/?login-error&ref='.urlencode($goTo);
            }
            
            header("Location: $goTo");
            exit;
        }
        $this->addTwigVars('ref', $goTo);
        $this->render();
    }

    /**
     * User logout
     * @return type
     */
    public function logoutAction()
    {
        global $_user, $_lang;

        if ($_user->logged){
            unset($_SESSION["logged"]); 
            unset($_SESSION["uID"]);
            session_destroy();
            
            $_user->unsetCookie();  
        }

        header("Location: /");
        exit;
    }

    /**
     * User register
     * @return type
     */
    public function registerAction()
    {
        global $_user, $_lang;

        if ($_user->logged){
            header("Location: /");
            exit;
        }

        // REF
        $goTo = '/';
        if (!empty($_REQUEST['ref'])) {
            $goTo = preg_match('/^([a-zA-Z0-9-_]+)$/', $_REQUEST['ref'])? "/${_REQUEST['ref']}/" : $_REQUEST['ref'];
        } else if (!empty($_SERVER['HTTP_REFERER'])) {
            $goTo = $_SERVER['HTTP_REFERER'];
        }

        //Sanatize the url (CR LF Header location Attacks and external urls)
        $goTo = parse_url($goTo, PHP_URL_PATH);
        $goTo = $goTo? $goTo : '/';

        //Register action
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name'])
        && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['name'])) {

            $user = new User;
            $_error = false;

            $_email = trim($_POST['email']);
            $_pass = $_POST['password'];
            $_name = trim($_POST['name']);


            if (empty($_email) || !filter_var($_email, FILTER_VALIDATE_EMAIL)) {
                $_error = true;
                $message_error = $_lang->l('error-email');
                $this->addTwigVars('message_error', $message_error);
                
            } else if ($user->isEmailRegistered($_email)) {
                $_error = true;
                $message_error = $_lang->l('error-email-exist');
                $this->addTwigVars('message_error', $message_error);
            }
            
            if (empty($_pass)) {
                $_error = true;
                $message_error = $_lang->l('error-pass');
                $this->addTwigVars('message_error', $message_error);
            }

            if (empty($_name)) {
                $_error = true;
                $message_error = $_lang->l('error-name');
                $this->addTwigVars('message_error', $message_error);
            }            

            $this->addTwigVars('error', $_error);
            // Check errors to continue
            if (!$_error) {
                echo "todo correcto";
                $user->active = 1;
                $user->password = $user->hashPassword($_POST['password']);
                $user->email = $_POST['email'];
                $user->name = $_POST['name'];

                if (isset($_POST['admin'])) {
                    $user->level = "admin";
                } else {
                    $user->level = "user";    
                }
            
                $user->language = $_lang->id? $_lang->id : 1;
                $user->dateRegister = date('Y-m-d H:i:s', time());
                $user->dateLastLogin = date('Y-m-d H:i:s', time());

                if ($user->save()) {

                    $user->cookie();
                    $user->setCookie();

                    header("Location: $goTo");
                    exit;
                }
            }
        }

        $this->addTwigVars('ref', $goTo);
        $this->render();
    }
}


