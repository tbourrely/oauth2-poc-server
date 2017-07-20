<?php
/**
 * File "Scope.php"
 * @author Thomas Bourrely
 * 18/07/2017
 */

namespace server\entities;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

class Scope implements ScopeEntityInterface
{

    /**
     * scope model
     *
     * @var
     */
    private $scopeModel;

    /**
     * Scope constructor.
     *
     * @param $id
     * @param $scope
     * @param $default
     */
    public function __construct( $scope )
    {
        $this->scopeModel = $scope;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->scopeModel->scope_id;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->scopeModel->scope_id;
    }

    /**
     * @return mixed
     */
    public function getScope()
    {
        return $this->scopeModel->scope;
    }
}