<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 12:00
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\symplicity\app;

abstract class ApplicationComponent
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function app()
    {
        return $this->app;
    }
}