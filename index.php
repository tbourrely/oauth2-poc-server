<?php
/**
 * File "index.php"
 * @author Thomas Bourrely
 * 17/07/2017
 */

require_once __DIR__ . '/vendor/autoload.php';

use mainApp\DatabaseFactory;
use server\repositories\ClientRepository;
use server\repositories\ScopeRepository;
use server\repositories\AccessTokenRepository;
use server\repositories\AuthCodeRepository;
use server\repositories\RefreshTokenRepository;

/******************
 * DATABASE CONNECTION
 *****************/

DatabaseFactory::setConfig();
DatabaseFactory::makeConnection();

/******************
 * END OF DATABASE CONNECTION
 *****************/


session_start();


$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);


// Get container
$container = $app->getContainer();

// Register twig-view on container
$container['views'] = function( $container ) {
    $view = new \Slim\Views\Twig('src/views', [
        'cache' => false // disable cache
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['AuthorizationServer'] = function( $container ) {
    $clientRepository = new ClientRepository();
    $accessTokenRepository = new AccessTokenRepository();
    $scopeRepository = new ScopeRepository();
    $authCodeRepository = new AuthCodeRepository();
    $refreshTokenRepository = new RefreshTokenRepository();

    $privateKey = __DIR__ . '/private.key';
    $publicKey = __DIR__ . '/public.key';

    $encryptionKey = __DIR__ . '/AuthServer.key';

    $server = new \League\OAuth2\Server\AuthorizationServer(
        $clientRepository,
        $accessTokenRepository,
        $scopeRepository,
        $privateKey,
        $publicKey
    );

    $grant = new League\OAuth2\Server\Grant\AuthCodeGrant(
        $authCodeRepository,
        $refreshTokenRepository,
        new DateInterval('PT1H')
    );

    $server->setEncryptionKey( file_get_contents( $encryptionKey ) );

    $server->enableGrantType(
        $grant,
        new DateInterval('PT1H')
    );

//    --- Client Grant Type ---
//    $server->enableGrantType(
//        new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
//        new DateInterval('PT1H')
//    );

    return $server;

};



/******************
 * START OF ROUTES
 *****************/

$app->get( '/', \mainApp\controllers\HomeController::class . ':home' )->setName('home');



// Handle authorization process => redirect to /login
$app->get( '/authorize', \server\controllers\AuthorizationController::class . ':authorize' )->setName('authorize.get');

// Verify login data => return code
$app->post( '/login', \server\controllers\AuthorizationController::class . ':login' )->setName('loginForm.post');

// Generate access token from the code
$app->post('/access_token', function ($request,  $response, $args) use ($app) {

    $server = $app->getContainer()->get('AuthorizationServer');
    try {

        // Try to respond to the request
        return $server->respondToAccessTokenRequest($request, $response);

    } catch (\League\OAuth2\Server\Exception\OAuthServerException $exception) {

        // All instances of OAuthServerException can be formatted into a HTTP response
        return $exception->generateHttpResponse($response);

    } catch (\Exception $exception) {

        // Unknown exception
        $body = new Stream('php://temp', 'r+');
        $body->write($exception->getMessage());
        return $response->withStatus(500)->withBody($body);
    }

});

/******************
 * END OF ROUTES
 *****************/


// start slim
$app->run();