<?php
/**
 * File "AccessTokenRepository.php"
 * @author Thomas Bourrely
 * 19/07/2017
 */

namespace server\repositories;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

use server\models\AccessToken;
use server\entities\AccessToken as AccessTokenEntity;

/**
 * Class AccessTokenRepository
 *
 * @package server\repositories
 */
class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @param ClientEntityInterface $clientEntity
     * @param array $scopes
     * @param null $userIdentifier
     * @return AccessTokenEntity
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
       return new AccessTokenEntity( new AccessToken() );
    }

    /**
     * @param AccessTokenEntityInterface $accessTokenEntity
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        AccessToken::updateOrCreate(
            [
                'client_id'     => $accessTokenEntity->getClient()->getIdentifier(),
            ],
            [
                'access_token'  => $accessTokenEntity->getIdentifier(),
                'expire_date'   => $accessTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s'),
                'scope_id'      => $accessTokenEntity->stringScopes(),
                'user_id'       => $accessTokenEntity->getUserIdentifier()
            ]
        );
    }

    /**
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        AccessToken::where( 'access_token', '=', $tokenId )->delete();
    }

    /**
     * @param string $tokenId
     * @return bool
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $token = AccessToken::where( 'access_token', '=', $tokenId )->first();

        if ( empty( $token->access_token ) )
            return true;

        return false;
    }
}