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
use server\models\Scope;

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
    }

    /**
     * @param int|string $identifier
     */
    public function setUserIdentifier($identifier)
    {
        $this->authCodeModel->user_id = $identifier;
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
    }

    /**
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        $this->authCodeModel->scope_id .= trim( $scope->getIdentifier() ) . ' ';
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        $scopes_list = preg_split('/\s+/', $this->authCodeModel->scope_id);

        $scopes = array();

        foreach ( $scopes_list as $scope ) {
            $scope_model = Scope::where( 'scope', '=', $scope )->first();

            if ( !empty( $scope_model->scope ) ) {
                array_push( $scopes, new ScopeEntity( $scope_model ) );
            }
        }

        return $scopes;
    }

    /**
     * @return mixed
     */
    public function stringScopes()
    {
        return $this->authCodeModel->scope_id;
    }
}