<?php
/**
 * File "User.php"
 * @author Thomas Bourrely
 * 17/07/2017
 */

namespace mainApp\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package mainApp\models
 */
class User extends Model
{

    /*******************
     * ELOQUENT CONFIG
     *******************/
    protected $connection   = 'users'; // define which database connection to use
    protected $table        = 'users';
    protected $primaryKey   = 'id';
    protected $fillable     = ['id', 'firstname', 'lastname', 'username', 'password'];

    public $timestamps      = false;
    /*******************
     * END OF ELOQUENT CONFIG
     *******************/

}