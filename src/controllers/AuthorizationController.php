<?php
/**
 * File "AuthorizationController.php"
 * @author Thomas Bourrely
 * 20/07/2017
 */

namespace server\controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use mainApp\controllers\BaseController;
use mainApp\models\User;
use server\entities\User as UserEntity;


/**
 * Class AuthorizationController
 *
 * @package mainApp\controllers
 */
class AuthorizationController extends BaseController
{
    /**
     * Redirect to login form
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return static
     */
    public function authorize( RequestInterface $request, ResponseInterface $response, $args )
    {
        $server =  $this->container['AuthorizationServer'];

        $authRequest = $server->validateAuthorizationRequest( $request );

        $_SESSION['authRequest'] = $authRequest;

        $request_uri = $request->getUri();
        $url = $request_uri->getScheme() . '://' . $request_uri->getHost() . '/login';

        return $response->withStatus(302)->withHeader('Location', 'http://oauth2-poc-app.local/api/login?redirect_uri=' . $url);
    }

    /**
     * Verify login post data => code
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return static
     */
    public function login( RequestInterface $request, ResponseInterface $response, $args )
    {
        $server =  $this->container['AuthorizationServer'];
        $params = $request->getParams();
        $errors = [];

        if ( !empty( $params['username'] )  && !empty( $params['password'] ) ) {
            $user = User::where('username', '=', $params['username'])->first();
            if ( $user ) {
                if ( password_verify( $params['password'], $user->password ) ) {

                    $authRequest = $_SESSION['authRequest'];

                    if ( !empty( $authRequest ) ) {

                        $authRequest->setUser( new UserEntity( $user ) );

                        // @todo redirect user to ask permission
                        $authRequest->setAuthorizationApproved( true ); // say the user has approved

                        return $server->CompleteAuthorizationRequest( $authRequest, $response );

                    } else {
                        $errors['authRequest'] = 'not present';
                    }


                } else {
                    $errors['password'] = 'password is not valid';
                }
            } else {
                $errors['user'] = 'not a user';
            }
        } else {
            $errors['request'] = 'request incomplete';
        }

        $request_uri = $request->getUri();
        $url = $request_uri->getScheme() . '://' . $request_uri->getHost() . '/login';

        return $response->withStatus(302)->withHeader('Location', 'http://oauth2-poc-app.local/api/login?redirect_uri=' . $url . '&status=failed');
    }


}