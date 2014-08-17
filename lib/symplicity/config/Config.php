<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 12:39
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\symplicity\config;

use lib\symplicity\app\ApplicationComponent;
use lib\vendors\Symfony\Component\Yaml\Yaml;

class Config extends ApplicationComponent
{
    protected $vars = array();

    public function get($var)
    {
        if (!$this->vars)
        {
            $yaml = Yaml::parse(file_get_contents( PATH_ROOT . '/apps/'.$this->app->name().'/config/config.yml'));

            foreach ($yaml as $key => $value)
            {
                $this->vars[$key] = $value;
            }
        }

        if (isset($this->vars[$var]))
        {
            return $this->vars[$var];
        }

        return null;
    }
}
