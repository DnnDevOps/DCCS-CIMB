<?php

namespace ObeliskAdmin;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Parser;

class AsteriskManager
{
	private static $instance;
	private $cookieJar;
	private $client;
	
	public static function getInstance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}
		
		return static::$instance;
	}
	
	protected function __construct()
	{
		$url = env('ASTERISK_MANAGER_URL', 'http://localhost:8088');
		$username = env('ASTERISK_MANAGER_USERNAME');
		$secret = env('ASTERISK_MANAGER_SECRET');
		
		$this->cookieJar = new CookieJar;
		
		$this->client = new Client(['base_uri' => $url]);
		$this->sendAction('Login', [
			'username' => $username,
			'secret' => $secret
		]);
	}

	function __destruct()
	{
		$this->sendAction('Logoff', []);
	}
	
	private function __clone()
	{
	}
	
	private function __wakeup()
	{
	}
	
	public function sendAction($action, $parameters)
	{
		$parameters['action'] = $action;
		
		$contents = $this->client->request('GET', 'mxml', [
			'cookies' => $this->cookieJar,
			'query' => $parameters
		])->getBody()->getContents();
		
		$response = Parser::xml($contents)['response'];

		if (count($response) == 2) {
			if (isset($response['generic'])) {
				return $response['generic']['@attributes'];
			} else {
				return $response[0]['@attributes'];
			}
		}
		
		return $response;
	}
    
    public function listCategories($filename)
    {
        $categories = [];
        
		$response = $this->sendAction('ListCategories', ['filename' => $filename]);
        
		if ($response['response'] == 'Success') {
            unset($response['response']);
            
            $categories = array_values($response);
        }
        
        return $categories;
    }
	
	public function getConfigJson($filename)
	{
		$json = [];
		
		$response = $this->sendAction('GetConfigJSON', ['filename' => $filename]);
		
		if ($response['response'] == 'Success') {
			$sanitazedJson = str_replace(['[', ']'], ['{', '}'], $response['json']);
			
			if ($sanitazedJson != '{}') {
				$json = Parser::json($sanitazedJson);
			}
		}
		
		return $json;
	}
	
	public function getConfig($filename, $category = NULL, $variable = NULL)
	{
		$lines = [];
		
		$paramaters = ['filename' => $filename];

		if ($category != NULL) {
			$paramaters['category'] = $category;
		}

		$response = $this->sendAction('GetConfig', $paramaters);

		if ($response['response'] == 'Success' && !isset($response['opaque_data'])) {
			$currentCategory = NULL;
			
			unset($response['response']);
			
			foreach ($response as $key => $value) {
				if (strpos($key, 'category') !== false) {
					$currentCategory = $value;
					$lines[$currentCategory] = [];

					continue;
				} else if ($currentCategory == $category) {
					if ($variable != NULL && strpos($value, "$variable=") === false) {
						continue;
					}
				}

				$lines[$currentCategory][] = $value;
			}
		}
		
		return $lines;
	}
	
	public function getConfigVariables($filename, $category)
	{
		$variables = [];
		
		foreach ($this->getConfig($filename, $category)[$category] as $line) {
			$keyValue = explode('=', $line);
			$variables[$keyValue[0]] = $keyValue[1];
		}
		
		return $variables;
	}
	
	public function updateConfig($configFile, $reload, $actions)
	{
		$parameters = [
			'SrcFilename' => $configFile,
			'DstFilename' => $configFile
		];
		
		if ($reload != null) {
			$parameters['Reload'] = $reload;
		}
		
		foreach ($actions as $index => $action) {
			$digit = str_pad($index, 6, '0', STR_PAD_LEFT);
			
			$fields = [
				'Action' => 'action',
				'Cat' => 'category',
				'Var' => 'variable',
				'Value' => 'value',
				'Match' => 'match',
				'Line' => 'line'
			];
			
			foreach ($fields as $parameterName => $actionName) {
				if (isset($action[$actionName])) {
					$parameters["$parameterName-$digit"] = $action[$actionName];
				}
			}
		}
		
		$this->sendAction('UpdateConfig', $parameters);
	}
	
	public function reload($module)
	{
		$this->sendAction('Reload', !empty($module) ? ['module' => $module] : []);
	}

	public function sipShowPeer($peer)
	{
		$fields = [];

		$response = $this->sendAction('SIPshowpeer', ['peer' => $peer]);

		if ($response['response'] == 'Success') {
            unset($response['response']);

			$fields = $response;
		}

		return $fields;
	}

	public function queueStatus($queue)
	{
		$fields = [];

		$response = $this->sendAction('QueueStatus', ['queue' => $queue]);

		if (count($response) > 2) {
			if ($response[0]['generic']['@attributes']['response'] == 'Success') {
				unset($response[1]['generic']['@attributes']['event']);

				$fields = $response[1]['generic']['@attributes'];
			}
		}

		return $fields;
	}
}