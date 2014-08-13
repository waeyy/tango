<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 13:04
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\symplicity\helper;

class ManagerCollection
{
    protected $api = null;
    protected $dao = null;
    protected $managers = array();
    protected $app;

    public function __construct($api, $dao, $app)
    {
        $this->api = $api;
        $this->dao = $dao;
        $this->app = $app;
    }

    public function getManagerOf($module)
    {
        if (!is_string($module) || empty($module))
        {
            throw new \InvalidArgumentException('Le module spécifié est invalide');
        }

        if (!isset($this->managers[$module]))
        {
            $manager = 'apps\\' . $this->app->name() . '\\modules\\' . $module . '\\models\\' . $module . 'Manager_' . $this->api;
            $this->managers[$module] = new $manager($this->dao);
        }

        return $this->managers[$module];
    }
}