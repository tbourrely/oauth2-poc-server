<?php
/**
 * File "RefreshToken.php"
 * @author Thomas Bourrely
 * 20/07/2017
 */

namespace server\entities;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

use server\models\AccessToken;
use server\entities\AccessToken as AccessTokenEntity;

/**
 * Class RefreshToken
 * @package server\entities
 */
class RefreshToken implements RefreshTokenEntityInterface
{
    /**
     * @var
     */
    private $refreshTokenModel;

    /**
     * RefreshToken constructor.
     * @param $token
     */
    public function __construct( $token )
    {
        $this->refreshTokenModel = $token;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->refreshTokenModel->refresh_token;
    }

    /**
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->refreshTokenModel->refresh_token = $identifier;
        $this->refreshTokenModel->save();
    }

    /**
     * @return \DateTime
     */
    public function getExpiryDateTime()
    {
        return new \DateTime( $this->refreshTokenModel->expire_date );
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setExpiryDateTime(\DateTime $dateTime)
    {
        $this->refreshTokenModel->expire_date = $dateTime->format('Y-m-d H:i:s');
        $this->refreshTokenModel->save();
    }

    /**
     * @param AccessTokenEntityInterface $accessToken
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {
        $this->refreshTokenModel->access_token = $accessToken->getIdentifier();
        $this->refreshTokenModel->save();
    }

    /**
     * @return null|\server\entities\AccessToken
     */
    public function getAccessToken()
    {
        $access_token = AccessToken::where('access_token', '=', $this->refreshTokenModel->access_token)->first();

        if ( $access_token->access_token ) {
            return new AccessTokenEntity( $access_token );
        }

        return null;
    }
}