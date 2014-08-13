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

class Config extends ApplicationComponent
{
    protected $vars = array();

    public function get($var)
    {
        if (!$this->vars)
        {
            $xml = new \DOMDocument;
            $xml->load( PATH_ROOT . '/apps/'.$this->app->name().'/config/config.xml');

            $elements = $xml->getElementsByTagName('define');

            foreach ($elements as $element)
            {
                $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
            }
        }

        if (isset($this->vars[$var]))
        {
            return $this->vars[$var];
        }

        return null;
    }
}
