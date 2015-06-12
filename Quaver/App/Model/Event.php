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

    public static function getProjectsToFinish()
    {
        $return = array();

        $db = new DB();

        $items = $db->query("SELECT id FROM event WHERE status = 'accepted' AND dateCreate > 0 AND dateFinish < NOW()");
        $result = $items->fetchAll();
        if ($result) {
            foreach ($result as $item) {
                $p = new self();
                $return[] = $p->getFromId($item['id']);
            }
        }

        return $return;
    }

} 
