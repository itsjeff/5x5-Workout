<?php namespace Jeffs\Router;

class Router
{
	// Matched route to uri
	protected $match = false;

	// Stored routes from routes.php
	protected $routes;	

	// Current uri
	protected $uri;
	
	// Verbs
	// protected $verbs = ['POST', 'GET', 'PUT', 'DELETE'];
	
	
	
	function __construct()
	{
		// Current uri
		$this->uri = (isset($_GET['uri'])) ? rtrim(htmlspecialchars($_GET['uri']), '/') : '';
	}
	
	
	
	/*
	 * Add route
	 */	
	public function add($uri, $action) 
	{
		$this->routes[] = array($uri, $action);
	}
	
	

	/*
	 * Set action
	 */
	protected function getAction($action, $params = null) 
	{
		// If it's not a function object, then
		// Else a controller
		
		if (is_object($action)) {
			call_user_func_array($action, $params);
		} else {
			// Explode param for class and method
			$explode = explode(':', $action['controller']);

			// Class aand method
			$class  = $explode[0];			
			$method = $explode[1];
			
			
			// Require our class controller			
			if (file_exists($controller_file = APP_PATH . '/controllers/' . $class . '.php')) {
				// Require needed controller class file	
				require_once(APP_PATH . '/controllers/BaseController.php');	
				
				require_once($controller_file);
				
				
				// get specific controller		
				if (class_exists($class)) {
					$get_class = new $class;				
				
					// Get method from class. Pass parameters if there are any
					if (count($params) > 0) {
						call_user_func_array(array($get_class, $method), $params);
					}
					else {
						call_user_func(array($get_class, $method));
					}
				} else {
					throw new \Exception('No such class "<em>' . $controller . '</em>"');
				}
			} else {
				throw new \Exception('There was a problem finding file path: <em>' . $controller_file . '</em>');
			}
		}	
	}

	

	/*
	 * Match route
	 */	
	protected function match_route()
	{	
		$uri = $this->uri;
		
		// Loop through routes
		foreach ($this->routes as $key => $val) {
			// Route
			$route = $val[0];
			
			// Param count
			$route_split = explode('/', $route);	
			$uri_split   = explode('/', $uri);
			
			$count = 0;
			$param_count = count($route_split);
			
			$params = array();
			
			// Match set route with uri
			if(preg_match('#^' . $this->get_regex($route) . '$#', $uri)) 
			{	
				// Set variables from url params
				foreach ($route_split as $param) {
					if(preg_match('/(?<=\{)(.+)(?=\})/', $param, $match)) {
						$name = $match[0];
						
						$params[$name] = $uri_split[$count];
					}
					
					$count++;	
				}		
				
				// Set Controller action
				$action = $val[1];
				
				echo $this->getAction($action, $params);
				
				// Matched
				$this->match = TRUE;
			}
			
		}
	}
	

	
	/*
	 * get Regex
	 */	
	protected function get_regex($route)
	{
		return preg_replace("/{\w+}/", "(.+)", $route);
	}
	
	
	
	/*
	 * Output routes
	 */
	public function output() 
	{
		// Check if there is a route or not
		if (! $this->uri) {			
			$action = $this->routes[0][1];
			
			echo $this->getAction($action);
		} else {		
			// Match Route
			$this->match_route();
			
			// Match not found
			if (! $this->match) {
				throw new \Exception('Could not match route.');
			}
		}
	}	
}
?>