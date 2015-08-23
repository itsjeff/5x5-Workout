<?php
// Register a simple autoloader
spl_autoload_register('autoload');

function autoload($className)
{
	if (file_exists($classFile = str_replace('\\', '/', $className) . '.php')) {
		require_once $classFile;
	}
}