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

}