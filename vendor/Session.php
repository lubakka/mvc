<?php

namespace Vendor;

/**
 * Description of Session
 *
 * @author lubakka
 */
class Session {

    private static $instance = null;

    protected function __construct() {
        if (version_compare(PHP_VERSION, '5.4', '>=')) {
            if (PHP_SESSION_NONE === session_status()) {
                session_start();
            }
        } elseif (!session_id()) {
            session_start();
        }
        $_SESSION['sid'] = $this->getSessionId();
        session_set_cookie_params(1800, '/', '', false, TRUE);
    }

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function __destruct() {
        unset($_SESSION);
    }

    public function getStatus() {
        return session_status();
    }
    
    public function getSession(){
        return $_SESSION;
    }

    public function getSessionId() {
        return session_id();
    }

}
