<?php
/**
 * File "User.php"
 * @author Thomas Bourrely
 * 20/07/2017
 */

namespace server\entities;

use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * Class User
 *
 * @package server\entities
 */
class User implements UserEntityInterface
{

    /**
     * @var
     */
    private $userModel;

    /**
     * User constructor.
     *
     * @param $user
     */
    public function __construct( $user )
    {
        $this->userModel = $user;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->userModel->id;
    }
}