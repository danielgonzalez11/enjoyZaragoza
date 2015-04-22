<?php


namespace Quaver\App\Model;

use Quaver\Core\DB;
use Quaver\Core\Model;

/**
 * User class
 * @package App
 */
class Event extends Model
{
    public $_fields = array(
      "id",
      "id_creator_user",
      "name",
      "dateCreate",
      "dateFinish",
      "state",
      "category"
    );

    public $cookie = '';
    public $logged = false;

    protected $table = 'event'; // sql table


    /**
    * Get users list
    * 
    * @access public
    * @return void
    */
    public function getList()
    {
        try {

            $db = new DB;
            $_table = $this->table;
            $return = false;

            $item = $db->query("SELECT id FROM $_table");

            $result = $item->fetchAll();

            if ($result) {
                foreach ($result as $item) {
                    $event = new Event;
                    $return[] = $event->getFromId($item['id']);
                }
            }

            return $return;

        } catch (PDOException $e) {
            throw new \Quaver\Core\Exception($e->getMessage());
        }
    }

    /**
    * Check if user is active
    * 
    * @access public
    * @return void
    */
    public function isActive() 
    {
        if ($this->id > 0) {
            return ($this->active == 1);
        }
    }

    // /**
    // * Cookie setter
    // * 
    // * @access public
    // * @param string $_cookie (default: '')
    // * @return void
    // */
    // public function setCookie($_cookie = '')
    // {
    //     if (!empty($_cookie)) {
    //         $this->cookie = $_cookie;
    //     }

    //     if (!empty($this->cookie)) {
    //         setCookie(COOKIE_NAME . "_log", $this->cookie, time() + 60 * 60 * 24 * 30, COOKIE_PATH, COOKIE_DOMAIN);    
    //     }
    // }

    // /**
    // * Unset user cookie
    // * 
    // * @access public
    // * @return void
    // */
    // public function unsetCookie()
    // {
    //     setCookie(COOKIE_NAME . "_log", "", time()-1, COOKIE_PATH, COOKIE_DOMAIN);
    //     setCookie("PHPSESSID", "", time()-1, COOKIE_PATH);

    //     $this->logged = false; 
    // }

    // /**
    // * Create new cookie
    // * 
    // * @access public
    // * @return void
    // */
    // public function cookie()
    // {
    //     if (empty($this->cookie) && !empty($this->id)) {
    //         $this->cookie = sha1($this->email . md5($this->id));
    //     }

    //     return $this->cookie;
    // }

    // *
    // * Get user from cookie
    // * 
    // * @access public
    // * @param mixed $_cookie
    // * @return void
    
    // public function getFromCookie($_cookie)
    // {
    //     try {

    //         $db = new DB;

    //         $this->cookie = substr($_cookie, 0, 40);
    //         $_table = $this->table;
    //         $_cookieSet = $this->cookie;

    //         $id = $db->query("
    //           SELECT id
    //           FROM $_table
    //           WHERE SHA1(CONCAT(email, MD5(id))) = '$_cookieSet'");

    //         $result = $id->fetchColumn(0);

    //         if ($result > 0) {
    //             $this->getFromId($result);
    //             if (!$this->isActive()) {
    //                 $this->unsetCookie();
    //             } else {
    //                 $this->logged = true;
    //             }
    //             $return = $this->id;
    //             $this->updateLastLogin();
    //         } else {
    //             $this->unsetCookie();
    //             $return = false;
    //         }

    //         return $return;

    //     } catch (PDOException $e) {
    //         throw new \Quaver\Core\Exception($e->getMessage());
    //     }

    // }
    
} 
