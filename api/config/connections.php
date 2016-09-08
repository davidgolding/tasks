<?php

use lithium\data\Connections;
use lithium\core\Libraries;

Connections::add('default', [
    'type' => 'database',
    'adapter' => 'Sqlite3',
    'database' => Libraries::realPath('resources') . '/data/tasks.db'
]);

?>