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

}