<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 12:01
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\symplicity\app;

use lib\symplicity\helper\ManagerCollection;
use lib\symplicity\config\PDOFactory;

abstract class Controller extends ApplicationComponent
{
    protected $action = '';
    protected $module = '';
    protected $page = null;
    protected $view = '';

    public function __construct(Application $app, $module, $action)
    {
        parent::__construct($app);

        $this->managers = new ManagerCollection('PDO', PDOFactory::getMysqlConnexion(), $app);
        $this->page = new Page($app);

        $this->setModule($module);
        $this->setAction($action);
        $this->setView($action);
    }

    public function execute()
    {
        $method = 'execute'.ucfirst($this->action);

        if (!is_callable(array($this, $method)))
        {
            throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
        }

        $this->$method($this->app->httpRequest());
    }

    public function page()
    {
        return $this->page;
    }

    public function setModule($module)
    {
        if (!is_string($module) || empty($module))
        {
            throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }

        $this->module = $module;
    }

    public function setAction($action)
    {
        if (!is_string($action) || empty($action))
        {
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }

        $this->action = $action;
    }

    public function setView($view)
    {
        if (!is_string($view) || empty($view))
        {
            throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
        }

        $this->view = $view;
        $this->page->setModuleName($this->module);
        $this->page->setContentFile( PATH_ROOT . '/apps/'.$this->app->name().'/modules/'.$this->module.'/templates/'.$this->view.'.html.twig', $this->view.'.html.twig');
    }
}