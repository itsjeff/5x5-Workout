<?php
namespace Core\Routing;

class Controller
{
	public function callAction($method, $class, $params = []) 
	{

		$class  = 'App\Controllers\\'.$class;
		$object = new $class;

		call_user_func_array([$object, $method], $params);
	}
}
