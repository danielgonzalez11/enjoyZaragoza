<?php


namespace Quaver\App\Model;

use Quaver\Core\DB;
use Quaver\Core\Model;

/**
 * User class
 * @package App
 */
class UserEvent extends Model
{
    public $_fields = array(
      "id",
      "id_user",
      "id_event"
    );
    
    protected $table = 'user_events'; // sql table

    public function getFollow($_event,$_user)
    {
        $db = new DB;
        $_event = (int)$_event;
        $_user = (int)$_user;
        $_table = $this->table;

        $item = $db->query("SELECT * FROM $_table WHERE id_user ='$_user' and id_event = '$_event'");

        $result = $item->fetchColumn(0);
        if ($result) {
            $this->getFromId($result);
        }

        return $this;
    }
}