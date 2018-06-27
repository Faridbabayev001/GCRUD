<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class GCrud
{
	/**
	 * The CodeIgniter object variable
	 * @var CI_Controller
	 */
	public $CI;

	/**
	 *  Crud options
	 * @var array
	 */
	private $options = array();

	public function __construct($params)
	{
		$this->CI =& get_instance();
		$this->options = (object)$params;
		$this->CI->load->helper('file');
		$this->init();

	}

	private function init()
	{
		$this->makeFolders();
	}

	/**
	 *  Make folder in controllers folder
	 */
	private function makeFolders()
	{
		foreach ($this->options->folders as $folder)
		{
			if (!is_dir(APPPATH.'/controllers/'.$folder))
			{
				mkdir(APPPATH.'/controllers/'.$folder, 0777, TRUE);
			}
		}
		$this->createControllers();
	}

	/**
	 *  Create controller in /application/controllers folder
	 */
	private function createControllers()
	{
		$this->createModel();
		foreach ($this->options->folders as $folder)
		{
			foreach ($this->options->controllers as $controller)
			{
				if (!file_exists(APPPATH.'/controllers/'.$folder.'/'.$controller.'.php'))
				{
					$data = $this->generateControllerContent($controller);
					write_file(APPPATH.'/controllers/'.$folder.'/'.$controller.'.php', $data);
				}
			}
		}
	}

	/**
	 * Create model in /application/models folder
	 */
	private function createModel()
	{
		foreach ($this->options->controllers as $controller)
		{
			$modelName = $controller.'_model';
			if (!file_exists(APPPATH.'/models/'.$modelName.'.php'))
			{
				$data = $this->generateModelContent($modelName,$controller);
				write_file(APPPATH.'/models/'.$modelName.'.php', $data);
			}
		}
	}

	/**
	 * Create controller content string
	 * @param $conrollerName
	 * @return string
	 */
	private function generateControllerContent($conrollerName)
	{
		$modelName = $conrollerName."_model";
		$params = array(
			'{controllerName}' => $conrollerName,
			'{loadModel}' => '$this->load->model("'.$modelName.'");',
			'{modelName}' => $modelName
		);
		$this->generateContent('controller.txt',$params);

	}

	/**
	 *  Create Model content string
	 * @param $modelName
	 * @return string
	 */
	private function generateModelContent($modelName,$controllerName)
	{
		$params = array(
			'{modelName}' => $modelName,
			'{tableName}' => $this->options->tables[$controllerName]
		);
		$this->generateContent('model.txt',$params);
	}

	/**
	 *  Load content from /templates path
	 * @param $templateName
	 * @param $params
	 * @return mixed
	 */
	private function generateContent($templateName,$params)
	{
		$fp = fopen(APPPATH.'/libraries/gcrud/templates/'.$templateName, "r");
		$content = fread($fp, filesize(APPPATH.'/libraries/gcrud/templates/'.$templateName));
		$find       = array_keys($params);
		$replace    = array_values($params);
		$new_string = str_ireplace($find, $replace, $content);
		return $new_string;
		fclose($fp);
	}

	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}
}
