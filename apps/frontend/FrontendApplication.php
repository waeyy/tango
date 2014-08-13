<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 13:27
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace apps\frontend;

use lib\symplicity\app\Application;

class FrontendApplication extends Application
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'frontend';
    }

    public function run()
    {
        $controller = $this->getController();
        $controller->execute();

        $this->httpResponse->setPage($controller->page());
        $this->httpResponse->send();
    }
}

