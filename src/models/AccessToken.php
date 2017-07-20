<?php
/**
 * File "AccessToken.php"
 * @author Thomas Bourrely
 * 18/07/2017
 */

namespace server\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AccessToken
 * @package server\models
 */
class AccessToken extends Model
{
    /*******************
     * ELOQUENT CONFIG
     *******************/
    protected $connection   = 'server';
    protected $table        = 'accessTokens';
    protected $primaryKey   = 'access_token';
    protected $fillable     = ['access_token', 'client_id', 'user_id', 'expire_date', 'scope_id'];

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
     * Return scope
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function scope()
    {
        return $this->belongsTo( 'server\models\Scope' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo( 'mainApp\models\User' );
    }
}