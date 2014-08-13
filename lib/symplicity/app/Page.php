<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 12:36
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\symplicity\app;

class Page extends ApplicationComponent
{
    protected $contentFile;
    protected $vars = array();

    public function addVar($var, $value)
    {
        if (!is_string($var) || is_numeric($var) || empty($var))
        {
            throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractère non nulle');
        }

        $this->vars[$var] = $value;
    }

    public function getGeneratedPage()
    {
        if (!file_exists($this->contentFile))
        {
            throw new \RuntimeException('La vue spécifiée n\'existe pas');
        }

        $user = $this->app->user();

        extract($this->vars);

        ob_start();
        require $this->contentFile;
        $content = ob_get_clean();

        ob_start();
        require PATH_ROOT . '/apps/'.$this->app->name().'/templates/layout.php';
        return ob_get_clean();
    }

    public function setContentFile($contentFile)
    {
        if (!is_string($contentFile) || empty($contentFile))
        {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }

        $this->contentFile = $contentFile;
    }
}