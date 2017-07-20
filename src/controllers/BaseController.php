<?php

/**
 * File "BaseController.php"
 * @author Thomas Bourrely
 * 17/07/2017
 */

namespace mainApp\controllers;

use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseController
 *
 * @package mainApp\controllers
 */
class BaseController
{
    /**
     * App container
     *
     * @var
     */
    protected $container;

    /**
     * BaseController constructor.
     *
     * @param $container
     */
    public function __construct( $container )
    {
        $this->container = $container;
    }

    /**
     * Render html
     *
     * @param ResponseInterface $response
     * @param $view
     * @param array $params
     */
    public function render(ResponseInterface $response, $view, $params = array())
    {
        $this->container->views->render($response, $view . '.html.twig', $params);
    }

    /**
     * Redirect to a route with the name : $name
     *
     * @param ResponseInterface $response
     * @param $name
     * @param array $params
     * @param int $status
     * @return static
     */
    public function redirect(ResponseInterface $response, $name, $params = array(), $status = 302)
    {
        return $response->withStatus(302)->withHeader('Location', $this->container->get('router')->pathFor($name, (!is_null($params) ? $params : [])));
    }
}