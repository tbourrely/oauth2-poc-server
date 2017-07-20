<?php
/**
 * File "HomeController.php"
 * @author Thomas Bourrely
 * 17/07/2017
 */

namespace mainApp\controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


/**
 * Class HomeController
 *
 * @package mainApp\controllers
 */
class HomeController extends BaseController
{
    /**
     * Render html for the homepage
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     */
    public function home( RequestInterface $request, ResponseInterface $response, $args )
    {
        return $this->render( $response, 'home' );
    }

}