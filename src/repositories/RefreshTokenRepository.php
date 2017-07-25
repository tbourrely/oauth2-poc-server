<?php
/**
 * File "RefreshTokenRepository.php"
 * @author Thomas Bourrely
 * 20/07/2017
 */

namespace server\repositories;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

use server\models\RefreshToken;
use server\entities\RefreshToken as RefreshTokenEntity;

/**
 * Class RefreshTokenRepository
 *
 * @package server\repositories
 */
class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{

    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity( new RefreshToken() );
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $refreshTokenModel = RefreshToken::firstOrNew(['refresh_token' => $refreshTokenEntity->getIdentifier()]);

        if ( empty( $refreshTokenModel->redirect_uri ) ) {
            $refreshTokenModel->expire_date = $refreshTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s');
            $refreshTokenModel->access_token = $refreshTokenEntity->getAccessToken()->getIdentifier();

            $refreshTokenModel->save();
        }
    }

    /**
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId)
    {
        RefreshToken::where( 'refresh_token', '=', $tokenId )->delete();
    }

    /**
     * @param string $tokenId
     * @return bool
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $token = RefreshToken::where( 'refresh_token', '=', $tokenId )->first();

        if ( empty( $token->refresh_token ) )
            return true;

        return false;
    }
}