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
      "time",
      "status",
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

} 
