<?php
// Register a simple autoloader
spl_autoload_register('autoload');

function autoload($className)
{
	$dir = 'core/';
	
	if (file_exists($classFile = $dir . str_replace('\\', '/', $className) . '.php')) {
		require_once $classFile;
	}
}