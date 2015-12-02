<?php

namespace core\Request;

class Request
{
	public $base_path;
	public $path_info = [];

	/**
	 * [__construct description]
	 */
	public function __construct($dir)
	{
		$this->base_path = $dir;

		$this->preparePathInfo();
	}

	/**
	 * [preparePathInfo description]
	 */
	private function preparePathInfo()
	{
		$port   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
		$domain = $_SERVER['HTTP_HOST'];
		$base_path = $this->base_path;

		if ($pos = strpos($this->base_path, $domain)) {
			$base_path = substr($base_path, ($pos + strlen($domain)));
		} 
		else {
			$base_path = '';
		}

		$this->path_info = [
			'port' => $port,
			'domain' => $domain,
			'base_path' => ltrim($base_path, '/')
			];
	}

	/**
	 * [getBaseUrl description]
	 */
	public function getBaseUrl()
	{
		$path_info = $this->path_info;

		return $path_info['port'].$path_info['domain'].$path_info['base_path'];
	}

	/**
	 * [getBaseUri description]
	 */
	public function getBaseUri()
	{
		$uri = (!isset($_SERVER['REQUEST_URI'])) ?: ltrim(htmlspecialchars($_SERVER['REQUEST_URI']), '/');

		if ($pos = strpos($uri, '?')) {
			$uri = substr($uri, 0, $pos);
		}

		if ($pos = strlen($this->path_info['base_path'])) {
			$uri = substr($uri, $pos);
		}

		return ltrim($uri, '/');
	}

	/**
	 * [url description]
	 */
	public function url($path = '')
	{
		$path = '/'.ltrim($path);

		return $this->getBaseUrl().$path;
	}
}
