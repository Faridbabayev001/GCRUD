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
				$data = $this->generateModelContent($modelName);
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
		return <<<EOD
	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class $conrollerName extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
    
    /**
	 *  Set form validation rules
	 * @return array
	 */
    private function setRules()
    {
    	return array();
    }
    
}

EOD;

	}

	/**
	 *  Create Model content string
	 * @param $modelName
	 * @return string
	 */
	private function generateModelContent($modelName)
	{
		return <<<EOD
<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class $modelName extends CI_Model  {
	
		public function __construct()
		{
			parent::__construct();
		}
		
		public function all()
		{
			//
		}
		
		public function find()
		{
			//
		}
		
		public function insert()
		{
			//
		}
		
		public function update()
		{
			//
		}
		
		public function destroy()
		{
			//
		}
	
	}
EOD;

	}

	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}
}
