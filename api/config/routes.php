<?php

use lithium\action\Response;
use lithium\net\http\Router;

/**
 * Paths to API: accepts only GET, POST, PUT, and DELETE requests
 * on the /items path.
 */
 
Router::connect('/items', ['http:method' => 'GET', 'Items::index']);

Router::connect('/items', ['http:method' => 'POST', 'Items::update']);

Router::connect('/items', ['http:method' => 'PUT', 'Items::update']);

Router::connect('/items', ['http:method' => 'DELETE', 'Items::delete']);

?>