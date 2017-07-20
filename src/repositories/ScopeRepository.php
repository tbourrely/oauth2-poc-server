<?php
/**
 * File "ScopeRepository.php"
 * @author Thomas Bourrely
 * 18/07/2017
 */

namespace server\repositories;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use server\models\Scope;
use server\entities\Scope as ScopeEntity;

/**
 * Class ScopeRepository
 * @package server\repositories
 */
class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * @param string $identifier
     * @return null|ScopeEntity
     */
    public function getScopeEntityByIdentifier( $identifier )
    {
        $scopeModel = new Scope();

        $scope = $scopeModel->getById( $identifier );

        if ( !empty( $scope->scope_id ) ) {
            return new ScopeEntity( $scope );
        }

        return null;
    }

    /**
     * @param array $scopes
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @param null $userIdentifier
     * @return array
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    )
    {
        return $scopes;
    }
}