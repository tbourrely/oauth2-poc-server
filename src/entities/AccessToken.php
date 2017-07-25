<?php
/**
 * File "AccessToken.php"
 * @author Thomas Bourrely
 * 18/07/2017
 */

namespace server\entities;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

use server\entities\Client as ClientEntity;
use server\entities\Scope as ScopeEntity;
use server\models\Scope;


/**
 * Class AccessToken
 *
 * @package server\entities
 */
class AccessToken implements AccessTokenEntityInterface
{
    /**
     * access token model
     *
     * @var
     */
    private $token;

    /**
     * AccessToken constructor.
     *
     * @param $token_model
     */
    public function __construct( $token_model )
    {
        $this->token = $token_model;
    }

    /**
     * @param CryptKey $privateKey
     * @return \Lcobucci\JWT\Token
     */
    public function convertToJWT(CryptKey $privateKey)
    {
        return (new Builder())
            ->setAudience($this->getClient()->getIdentifier())
            ->setId($this->getIdentifier(), true)
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration($this->getExpiryDateTime()->getTimestamp())
            ->setSubject($this->getUserIdentifier())
            ->set('scopes', $this->getScopes())
            ->sign(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase()))
            ->getToken();
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->token->access_token;
    }

    /**
     * @param $identifier
     */
    public function setIdentifier( $identifier )
    {
        $this->token->access_token = $identifier;
    }

    /**
     * @return \DateTime
     */
    public function getExpiryDateTime()
    {
        return new \DateTime( $this->token->expire_date );
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setExpiryDateTime(\DateTime $dateTime)
    {
        $this->token->expire_date = $dateTime->format('Y-m-d H:i:s');
    }

    /**
     * @param int|string $identifier
     */
    public function setUserIdentifier($identifier)
    {
        $this->token->user_id = $identifier;
    }

    /**
     * @return mixed
     */
    public function getUserIdentifier()
    {
        return $this->token->user_id;
    }

    /**
     * @return \server\entities\Client
     */
    public function getClient()
    {
        $client = $this->token->client()->first();
        return new ClientEntity( $client );
    }

    /**
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client)
    {
        $this->token->client_id = $client->getIdentifier();
    }

    /**
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        $this->token->scope_id .= trim( $scope->getIdentifier() ) . ' ';
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        $scopes_list = preg_split('/\s+/', $this->token->scope_id);

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
        return $this->token->scope_id;
    }
}