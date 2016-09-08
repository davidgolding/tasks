<?php

use lithium\action\Dispatcher;
use lithium\aop\Filters;
use lithium\core\Libraries;
use lithium\core\Environment;

Filters::apply(Dispatcher::class, 'run', function($params, $next) {
	Environment::set($params['request']);
	foreach (array_reverse(Libraries::get()) as $name => $config) {
		if ($name === 'lithium') {
			continue;
		}
		$file = "{$config['path']}/config/routes.php";
		file_exists($file) ? call_user_func(function() use ($file) { include $file; }) : null;
	}
	return $next($params);
});

?>