<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 13:08
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\symplicity\kernel;

use lib\symplicity\app\ApplicationComponent;
use lib\symplicity\app\Page;

class HTTPResponse extends ApplicationComponent
{
    protected $page;

    public function addHeader($header)
    {
        header($header);
    }

    public function redirect($location)
    {
        header('Location: '.$location);
        exit;
    }

    public function redirect404()
    {
        $this->page = new Page($this->app);
        $this->page->setContentFile(PATH_ROOT . '/errors/404.html');

        $this->addHeader('HTTP/1.0 404 Not Found');

        $this->send();
    }

    public function send()
    {
        exit($this->page->getGeneratedPage());
    }

    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

}