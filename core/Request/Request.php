<?php

namespace core\Request;

class Request
{
	public $baseUrl;

	public $basePath;

	public $pathInfo = [];


	/**
	 * Constructor
	 */
	public function __construct($dir)
	{
		$this->basePath = $dir;

		$this->preparePathInfo();
	}

	/**
	 * Prep all information about the url such as protocol, domain, path
	 */
	private function preparePathInfo()
	{
		$port   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
		$domain = $_SERVER['HTTP_HOST'];
		$baseUrl = $this->getBaseUrl();

		$this->pathInfo = [
			'port' => $port,
			'domain' => $domain,
			'base_path' => $baseUrl
			];
	}

	/**
	 * Get base path
	 * 
	 * @return string Return base path leading up to file
	 */
	public function getBaseUrl()
	{
		if ($this->baseUrl === null) {
			$this->baseUrl = $this->prepareBaseUrl();	
		}

		return $this->baseUrl;
	}

	/**
	 * Get uri after base url
	 * 
	 * @return string Return uri after base url
	 */
	public function getBaseUri()
	{
		$uri = (!isset($_SERVER['REQUEST_URI'])) ?: ltrim(htmlspecialchars($_SERVER['REQUEST_URI']), '/');

		if ($pos = strpos($uri, '?')) {
			$uri = substr($uri, 0, $pos);
		}

		if ($pos = strlen($this->pathInfo['base_path'])) {
			$uri = substr($uri, $pos);
		}

		return ltrim($uri, '/');
	}

	/**
	 * Prepare base url up to file location
	 * 
	 * @return string Return prepared base url
	 */
	public function prepareBaseUrl()
	{
		$baseUrl = $_SERVER['PHP_SELF'];
		$baseUrl = rtrim(dirname($baseUrl), '/'.DIRECTORY_SEPARATOR);

		return $baseUrl;
	}

	/**
	 * Return full url with specified path or file
	 * 
	 * @param  string $to Path or file name
	 * @return [type]     Return full path
	 */
	public function url($to = '')
	{
		$pathInfo = $this->pathInfo;

		$url = $pathInfo['port'].$pathInfo['domain'].$pathInfo['base_path'].'/';

		return $url.$to;
	}
}
