<?php

/**
 * Description of the phpfile 'bootstrap.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

$classLoaderFilepath = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($classLoaderFilepath)) {
    die('ClassLoader can\'t be loaded.');
}
$classLoader = require $classLoaderFilepath;
