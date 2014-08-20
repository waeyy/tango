<?php
/**
 * This file is part of the Symplicity Web Application Package.
 *
 * 13/08/14 11:51
 * (c) Djamil SOIDIKI <soidikid@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\symplicity\autoload;

class autoload
{
    /**
     * Charge la classe donnée
     *
     * @param  string    $class Le nom de la classe
     * @return bool|null True, si chargée
     */
    public function loadClass($class)
    {
        $file = str_replace('\\', '/', $class) . '.php';
        $filePath = PATH_ROOT . '/' . $file;

        if (false !== strpos($class, 'Twig'))
        {
            return false;
        }
        if(file_exists($filePath)) {
            include $filePath;
            return true;
        }else {
            echo $filePath;
            throw new \Exception(sprintf('La classe "%s" que vous tentez de charger n\'existe pas. Impossible de la rajouter à la pile.', $class));
        }
    }

    /**
     * Enregistre l'instance dans la pile autoload.
     */
    public function register()
    {
        spl_autoload_register(array(__CLASS__, 'loadClass'));
    }

    /**
     * Annule l'inscription de l'instance de la pile autoload.
     */
    public function unregister()
    {
        spl_autoload_unregister(array(__CLASS__, 'loadClass'));
    }

}