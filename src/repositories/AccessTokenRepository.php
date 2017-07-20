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
        $tokenModel = new AccessToken();

        $date = new \DateTime('tomorrow');
        $date = $date->format('Y-m-d H:i:s');

        $generated_token = md5(uniqid( $clientEntity->getIdentifier(), true ));



        $token = $tokenModel->firstOrNew(
            [
                'client_id' => $clientEntity->getIdentifier()
            ]
        );

       if ( empty( $token->access_token ) ) {



           $token->access_token = $generated_token;
           $token->user_id = $userIdentifier;
           $token->expire_date = $date;
           $token->scope_id = 0; // testing

           $token->save();
       }

       return new AccessTokenEntity( $token );
    }

    /**
     * @param AccessTokenEntityInterface $accessTokenEntity
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        // TODO: Implement persistNewAccessToken() method.
    }

    /**
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        // TODO: Implement revokeAccessToken() method.
    }

    /**
     * @param string $tokenId
     * @return bool
     */
    public function isAccessTokenRevoked($tokenId)
    {
        // TODO: Implement isAccessTokenRevoked() method.
        return false;
    }
}