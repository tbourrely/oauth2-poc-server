<?php
/**
 * File "Scope.php"
 * @author Thomas Bourrely
 * 18/07/2017
 */

namespace server\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Scope
 * @package server\models
 */
class Scope extends Model
{

    /*******************
     * ELOQUENT CONFIG
     *******************/
    protected $connection   = 'server';
    protected $table        = 'scopes';
    protected $primaryKey   = 'scope_id';
    protected $fillable     = ['scope_id', 'scope', 'is_default'];

    public $timestamps      = false;
    /*******************
     * END OF ELOQUENT CONFIG
     *******************/

    /**
     * @param $id
     * @return mixed
     */
    public function getById( $id )
    {
        return $this->where('scope_id', '=', $id)->first();
    }

    /**
     * Return tokens
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens()
    {
        return $this->hasMany( 'server\models\AccessToken' );
    }
}