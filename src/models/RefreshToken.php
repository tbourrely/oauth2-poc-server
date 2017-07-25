<?php
/**
 * File "AuthCode.php"
 * @author Thomas Bourrely
 * 20/07/2017
 */

namespace server\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthCode
 *
 * @package mainApp\models
 */
class RefreshToken extends Model
{
    /*******************
     * ELOQUENT CONFIG
     *******************/
    protected $connection   = 'server';
    protected $table        = 'refreshTokens';
    protected $primaryKey   = 'refresh_token';
    protected $fillable     = ['refresh_token', 'expire_date', 'access_token'];

    public $timestamps      = false;
    public $incrementing    = false;
    /*******************
     * END OF ELOQUENT CONFIG
     *******************/
}