<?php


namespace Quaver\App\Model;

use Quaver\Core\DB;
use Quaver\Core\Model;

/**
 * User class
 * @package App
 */
class EventFile extends Model
{
    public $_fields = array(
      "id",
      "event",
      "source",
      "file"
    );
    
    protected $table = 'events_files'; // sql table

}