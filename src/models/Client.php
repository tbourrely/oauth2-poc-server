<?php
/**
 * File "Client.php"
 * @author Thomas Bourrely
 * 18/07/2017
 */

namespace server\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 * @package mainApp\models
 */
class Client extends Model
{

    /*******************
     * ELOQUENT CONFIG
     *******************/
    protected $connection   = 'server';
    protected $table        = 'clients';
    protected $primaryKey   = 'client_id';
    protected $fillable     = ['client_id', 'client_secret', 'name', 'redirect_uri'];

    public $timestamps      = false;
    public $incrementing    = false;
    /*******************
     * END OF ELOQUENT CONFIG
     *******************/

    /**
     * @param $id
     * @return mixed
     */
    public function getById( $id )
    {
        return $this->where('client_id', '=', $id)->first();
    }

    /**
     * Return the token associated
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function token()
    {
        return $this->hasOne( 'server\models\AccessToken' );
    }

}