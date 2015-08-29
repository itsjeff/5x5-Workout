<?php
namespace Jeff\COntainer;

use ReflectionClass;
use Jeff\Routing\Router;

class Container
{
	public function __construct()
	{
		echo 'launched container';
	}


	/**
	 * [build description]
	 * @param  [type] $concrete [description]
	 * @return [type]           [description]
	 */
	public function build($concrete)
	{
		$reflector   = new ReflectionClass($concrete);

		if (! $reflector->isInstantiable()) {
			//
		}

		$constructor = $reflector->getConstructor();

		if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();

		$instances = $this->getDependencies($dependencies);

		// Place new dependencies in origional concrete
        return $reflector->newInstanceArgs($instances);
	}


	/**
	 * [getDependencies description]
	 * @param  array  $parameters [description]
	 * @return [type]             [description]
	 */
  	protected function getDependencies(array $parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            $dependencies[] = new $dependency->name;
        }

        return (array) $dependencies;
    }
}

// Eveything else
//$container = new Container;
//$test = $container->build('Foo');