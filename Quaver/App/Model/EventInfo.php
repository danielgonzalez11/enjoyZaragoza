<?php


namespace Quaver\App\Model;

use Quaver\Core\DB;
use Quaver\Core\Model;

/**
 * User class
 * @package App
 */
class EventInfo extends Model
{
    public $_fields = array(
      "id_event",
      "description",
      "phone",
      "price",
      "capacity",
      "details"

    );
    protected $table = 'events_info'; // sql table



    public function getFromEvent($_event)
    {
        $db = new DB;
        $_event = (int)$_event;
        $_table = $this->table;

        $item = $db->query("SELECT * FROM $_table WHERE id_event = '$_event'");

        $result = $item->fetchAll();

        if ($result) {
            $this->setItem($result[0]);
        }

        return $this;
    }

}