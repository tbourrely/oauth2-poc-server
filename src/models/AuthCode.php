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
class AuthCode extends Model
{
    /*******************
     * ELOQUENT CONFIG
     *******************/
    protected $connection   = 'server';
    protected $table        = 'authorizationCodes';
    protected $primaryKey   = 'authorization_code';
    protected $fillable     = ['authorization_code', 'client_id', 'user_id', 'redirect_uri', 'expire_date', 'scope_id'];

    public $timestamps      = false;
    public $incrementing    = false;
    /*******************
     * END OF ELOQUENT CONFIG
     *******************/

    /**
     * Return the associated client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo( 'server\models\Client' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo( 'mainApp\models\User' );
    }
}