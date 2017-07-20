<?php
/**
 * File "AuthCode.php"
 * @author Thomas Bourrely
 * 20/07/2017
 */

namespace server\entities;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

use server\entities\Client as ClientEntity;
use server\entities\Scope as ScopeEntity;

/**
 * Class AuthCode
 *
 * @package server\entities
 */
class AuthCode implements AuthCodeEntityInterface
{
    /**
     * @var
     */
    private $authCodeModel;

    /**
     * AuthCode constructor.
     *
     * @param $authCode
     */
    public function __construct( $authCode )
    {
        $this->authCodeModel = $authCode;
    }

    /**
     * @return mixed
     */
    public function getRedirectUri()
    {
        return $this->authCodeModel->redirect_uri;
    }

    /**
     * @param string $uri
     */
    public function setRedirectUri($uri)
    {
        $this->authCodeModel->redirect_uri = $uri;
        $this->authCodeModel->save();
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->authCodeModel->authorization_code;
    }

    /**
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->authCodeModel->authorization_code = $identifier;
        $this->authCodeModel->save();
    }

    /**
     * @return \DateTime
     */
    public function getExpiryDateTime()
    {
        return new \DateTime( $this->authCodeModel->expire_date );
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setExpiryDateTime(\DateTime $dateTime)
    {
        $this->authCodeModel->expire_date = $dateTime->format('Y-m-d H:i:s');
        $this->authCodeModel->save();
    }

    /**
     * @param int|string $identifier
     */
    public function setUserIdentifier($identifier)
    {
        $this->authCodeModel->user_id = $identifier;
        $this->authCodeModel->save();
    }

    /**
     * @return mixed
     */
    public function getUserIdentifier()
    {
        return $this->authCodeModel->user_id;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        $client = $this->authCodeModel->client()->first();
        return new ClientEntity( $client );
    }

    /**
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client)
    {
        $this->authCodeModel->client_id = $client->getIdentifier();
        $this->authCodeModel->save();
    }

    /**
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        $this->authCodeModel->scope_id = $scope->getIdentifier();
        $this->authCodeModel->save();
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        $scope = $this->authCodeModel->scope()->first();
        return [new ScopeEntity( $scope )];
    }
}