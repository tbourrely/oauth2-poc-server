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


        $scopeModel = Scope::where( 'scope', $identifier )->first();

        if ( !empty( $scopeModel->scope ) ) {
            return new ScopeEntity( $scopeModel );
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