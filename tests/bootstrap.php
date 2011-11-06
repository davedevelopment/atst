<?php
/**
 * @package
 * @subpackage
 */

/**
 * TITLE
 *
 * DESCRIPTION
 *
 * @author      Dave Marshall <david.marshall@atstsolutions.co.uk>
 */
if (file_exists($file = __DIR__.'/../autoload.php')) {
    require_once $file;
} elseif (file_exists($file = __DIR__.'/../autoload.php.dist')) {
    require_once $file;
}


