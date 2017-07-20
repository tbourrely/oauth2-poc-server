<?php

/**
 * File "ClientRepository.php"
 * @author Thomas Bourrely
 * 18/07/2017
 */

namespace server\repositories;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use server\models\Client;
use server\entities\Client as ClientEntity;

/**
 * Class ClientRepository
 *
 * @package server\repositories
 */
class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @param string $clientIdentifier
     * @param string $grantType
     * @param null $clientSecret
     * @param bool $mustValidateSecret
     * @return null|ClientEntity
     */
    public function getClientEntity( $clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true )
    {
        $clientModel = new Client();

        $client = $clientModel->getById( $clientIdentifier );


        if ( !empty( $client->client_id ) ) {
             // @todo Check secret
            return new ClientEntity( $client );
        }

        return null;
    }
}