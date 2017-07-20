<?php

/**
 * File "Client.php"
 * @author Thomas Bourrely
 * 18/07/2017
 */
namespace server\entities;

use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * Class Client
 *
 * @package server\entities
 */
class Client implements ClientEntityInterface
{

    /**
     * client model
     *
     * @var
     */
    private $client;

    /**
     * Client constructor.
     *
     * @param $id
     * @param $name
     * @param $redirect_uri
     */
    public function __construct( $client )
    {
        $this->client = $client;
    }

    /**
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->client->client_id;
    }

    /**
     * Get the client's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->client->name;
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->client->redirect_uri;
    }
}