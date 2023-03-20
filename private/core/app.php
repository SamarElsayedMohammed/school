<?php

/**
 * main app file
 */
class App
{
	protected $controller = "Home";
	protected $method = "index";
	protected $params = array();

	public function __construct()
	{
		// code...
		$URL = $this->getURL();
		// var_dump(ucfirst($URL[0]));

		// var_dump(file_exists("../private/controllers/" .ucfirst($URL[0]) . ".php"));

		if(file_exists("../private/controllers/".ucfirst($URL[0]).".php"))
		{
			$this->controller = ucfirst($URL[0]);
			unset($URL[0]);
		}else
		{
			echo "<center><h1>controller not found</h1></center>";
			die;
		}
		// var_dump("../private/controllers/" . $this->controller . ".php");
		require "../private/controllers/" . $this->controller . ".php";
		$this->controller = new $this->controller();

		if (isset($URL[1])) {
			if (method_exists($this->controller, $URL[1])) {
				$this->method = ucfirst($URL[1]);
				unset($URL[1]);
			}
		}

		$URL = array_values($URL);
		$this->params = $URL;

		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	private function getURL()
	{

		$url = str_replace("/public/", '',(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
		$url = !empty($url) ? $url : "home";
		return explode("/", filter_var(trim($url, "/")), FILTER_SANITIZE_URL);


		// var_dump($url);
		// var_dump(str_replace("/public/", '', $url));
		// $url = trim($url, "public");
		// $url = (trim($url, "/"));
		// $url = (trim($url, "public"));
		// $url = (trim($url, "/"));
		/*
		//-- work on apache server only 
		$url = isset($_GET['url']) ? $_GET['url'] : "home";
		return explode("/", filter_var(trim($url,"/")),FILTER_SANITIZE_URL);
		*/
	}
}
