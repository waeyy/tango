<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 11:57
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\symplicity\app;

use lib\symplicity\config\Config;
use lib\symplicity\config\User;
use lib\symplicity\kernel\HTTPRequest;
use lib\symplicity\kernel\HTTPResponse;
use lib\symplicity\routing\Route;
use lib\symplicity\routing\RouteCollection;
use lib\vendors\Symfony\Component\Yaml\Yaml;

abstract class Application
{
    protected $config;
    protected $httpRequest;
    protected $httpResponse;
    protected $name;
    protected $user;

    public function __construct()
    {
        $this->config = new Config($this);
        $this->httpRequest = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
        $this->user = new User($this);

        $this->name = '';
    }

    public function getController()
    {
        $router = new RouteCollection($this);
        $yaml = Yaml::parse(file_get_contents( PATH_ROOT . '/apps/' . $this->name . '/config/routing.yml'));

        foreach ($yaml as $key => $value)
        {
            $inc = Yaml::parse(file_get_contents( PATH_ROOT . '/apps/' . $this->name . '/modules/' . $value['module']['name'] . '/config/' . $value['module']['routing'] . ''));

            foreach ($inc as $keys => $values)
            {
                $vars = array();

                if (isset($values['vars']))
                {
                    $vars = explode(',', $values['vars']);
                }

                $url = $value['module']['pattern'];
                if ($value['module']['pattern'] != $values['url'])
                    $url .= $values['url'];

                $router->addRoute(new Route($url, $values['keys']['module'], $values['keys']['action'], $vars));
            }
        }

        try
        {
            // On récupère la route correspondante à l'URL
            $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
        }
        catch (\RuntimeException $e)
        {
            if ($e->getCode() == RouteCollection::NO_ROUTE)
            {
                // Si aucune route ne correspond, c'est que la page demandée n'existe pas
                $this->httpResponse->redirect404();
            }
        }

        // On ajoute les variables de l'URL au tableau $_GET
        $_GET = array_merge($_GET, $matchedRoute->vars());

        // On instancie le contrôleur
        $controllerClass = 'apps\\' . $this->name . '\\modules\\' . $matchedRoute->module() . '\\' . $matchedRoute->module() . 'Controller';
        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
    }

    abstract public function run();

    public function config()
    {
        return $this->config;
    }

    public function httpRequest()
    {
        return $this->httpRequest;
    }

    public function httpResponse()
    {
        return $this->httpResponse;
    }

    public function name()
    {
        return $this->name;
    }

    public function user()
    {
        return $this->user;
    }
}