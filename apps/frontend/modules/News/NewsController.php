<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 17/08/14 16:05
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace apps\frontend\modules\news;

use lib\symplicity\app\Controller;
use lib\symplicity\kernel\HTTPRequest;

class NewsController extends Controller
{
    public function executeIndex(HTTPRequest $request)
    {
        $var = $this->app->config()->get('options_routes');
        $this->page->addVar('varus', $var);
    }
}