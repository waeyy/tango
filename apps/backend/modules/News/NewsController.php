<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 18/08/14 00:38
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace apps\backend\modules\news;

use lib\symplicity\app\Controller;
use lib\symplicity\kernel\HTTPRequest;

class NewsController extends Controller
{
    public function executeIndex(HTTPRequest $request)
    {
        $var = $this->app->config()->get('title_homepage');
        $this->page->addVar('title_homepage', $var);
    }

    public function executeGoIndex(HTTPRequest $request)
    {
        $this->app->httpResponse()->redirect('news/');
    }
}
