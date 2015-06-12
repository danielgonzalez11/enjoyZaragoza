<?php


namespace Quaver\App\Model;

use Quaver\Core\DB;
use Quaver\Core\Model;

/**
 * User class
 * @package App
 */
class Category extends Model
{
    public $_fields = array(
      "id",
      "category"
    );


protected $table = 'category'; // sql table

    public function getListCategory(){
    	try {

            $db = new DB;
            $_table = $this->table;
            $return = false;

            $item = $db->query("SELECT id,category FROM $_table");
            $result = $item->fetchAll();
            return $result;

        } catch (PDOException $e) {
            throw new \Quaver\Core\Exception($e->getMessage());
        }
    }
}