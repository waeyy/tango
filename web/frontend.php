<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 13:22
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define('PATH_ROOT', dirname(dirname(__FILE__)));

include('../lib/symplicity/autoload/autoload.php');
include('../lib/vendors/Symfony/Component/Twig/Autoloader.php');

Twig_Autoloader::register();

$autoload = new lib\symplicity\autoload\autoload();
$autoload->register();

$app = new apps\frontend\FrontendApplication;
$app->run();