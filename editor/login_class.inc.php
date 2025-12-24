<?php

class ses {

    var $user = '';
    var $logged_in = false;
    var $expire_time = 10800;
    var $login_error = '';
    
    function ses($db) {
            ini_set("session.gc_maxlifetime","10800");
            session_start();
            $this->check_all();
            $this->session_setup();
    }
    
    function session_setup() {
        $_SESSION['logged_in'] = $this->logged_in;
        $_SESSION['user'] = $this->user;
    }

    function check_all() {
        $session = $this->check_session();
        $cookie = $this->check_cookie();
        
        if($session AND $cookie) {
            $this->logged_in = true;
            $this->user = $_SESSION['user'];
            $this->userid = $_SESSION['userid'];
            $this->perm = $_SESSION['perm'];
        }
        elseif($session AND !$cookie) {
            $this->login_error = 'No activity for '.$this->expire_time.' seconds.';
         }
        else {
            $this->login_error = 'You have not logged in.';
        }
        return;
    }

    // Login SESSION Check Function
    function check_session() {
        if($_SESSION['logged_in']) {
            return true;
        }
        else {
            return false;
        }
    }

    // Login COOKIE Check Function
    function check_cookie() {
        if($_COOKIE['logged_in']) {
            $this->cookie_set();
            return true;
        }
        else {
            return false;
        }
    }

    function check_info($user, $pass) {
    
        $en_pass = md5($pass);

        $upath    =     'private/user.txt';
        $ppath    =     'private/pass.txt';
          
        if(file_exists($upath) && file_exists($ppath)) {

            if( $user == file_get_contents($upath) && $pass == file_get_contents($ppath) ) {
            
            $this->user = file_get_contents($upath);
            return true;
            }
            else {
              $this->login_error = 'Incorrect Username or Password.';
            }
          }
          else {
          $this->login_error = 'There does not appear to be a match.';
          }
   }

    function login($user, $pass) {
    
        $valid_login = $this->check_info($user, $pass);
        
        if($valid_login == true) {
            $this->cookie_set();
            $this->logged_in = true;
            $this->session_setup();
        }
        return;
    }
    
    function cookie_set() {
        setcookie('logged_in', true, time() + $this->expire_time);
        return;
    }

    // Custom COOKIE unset Function
    function cookie_unset() {
        setcookie('logged_in', false, time() - 1);
        return;
    }


    function logout() {

        $this->cookie_unset();
        $_SESSION = array();
        session_destroy();
        return;                    
    }
    
}
?>