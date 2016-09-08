<?php

define('LITHIUM_APP_PATH', dirname(__DIR__));

define('LITHIUM_LIBRARY_PATH', dirname(dirname(dirname(LITHIUM_APP_PATH))) . '/Libraries'); //replace with server path to Lithium parent directory

if (!include LITHIUM_LIBRARY_PATH . '/lithium/core/Libraries.php') {
    $message  = "Lithium could not be found. Check the value of LITHIUM_LIBRARY_PATH in ";
    $message .= __FILE__ . ".";
    throw new ErrorException($message);
}

use lithium\core\Libraries;

Libraries::add('lithium');

Libraries::add('tasks', ['default' => true]);

?>