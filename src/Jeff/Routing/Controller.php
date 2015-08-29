<?php
namespace Jeff\Routing;

use ReflectionClass;

class Controller
{
	/**
	 * [callAction description]
	 * @param  [type] $method [description]
	 * @param  [type] $class  [description]
	 * @param  array  $params [description]
	 * @return [type]         [description]
	 */
	public function callAction($method, $class, $params = []) 
	{
		$class  = 'App\Controllers\\'.$class;
		$object = new $class;

		call_user_func_array([$object, $method], $params);
	}
}
