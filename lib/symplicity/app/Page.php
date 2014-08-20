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
    protected $module_name;
    protected $fileName;
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
        $path_template = PATH_ROOT .'/apps/'. $this->app->name() .'/modules/' . $this->module_name . '/templates';

        $loader = new \Twig_Loader_Filesystem($path_template); // Dossier contenant les templates
        $twig = new \Twig_Environment($loader, array(
            'cache' => false,
        ));

        echo $twig->render($this->fileName, $this->vars);
        $content = ob_get_clean();

        ob_start();
        $path_layout = PATH_ROOT . '/apps/'.$this->app->name().'/templates/';
        $loader = new \Twig_Loader_Filesystem($path_layout); // Dossier contenant les templates
        $twig = new \Twig_Environment($loader, array(
            'cache' => false,
            'autoescape' => false
        ));
        echo $twig->render('layout.html.twig', array(
            'content' => $content
        ));
        return ob_get_clean();
    }

    public function setModuleName($name)
    {
        $this->module_name = $name;
    }

    public function setContentFile($contentFile, $fileName)
    {
        if (!is_string($contentFile) || empty($contentFile))
        {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }

        $this->contentFile = $contentFile;
        $this->fileName = $fileName;

    }
}