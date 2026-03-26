<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
#[AllowDynamicProperties]
class CI_Controller {

	private static $instance;

	/**
	 * Benchmark class
	 * @var CI_Benchmark
	 */
	public $benchmark;
	/**
	 * Hooks class
	 * @var CI_Hooks
	 */
	public $hooks;
	/**
	 * Config class
	 * @var CI_Config
	 */
	public $config;
	/**
	 * UTF-8 class
	 * @var CI_Utf8
	 */
	public $utf8;
	/**
	 * URI class
	 * @var CI_URI
	 */
	public $uri;
	/**
	 * Router class
	 * @var CI_Router
	 */
	public $router;
	/**
	 * Output class
	 * @var CI_Output
	 */
	public $output;
	/**
	 * Security class
	 * @var CI_Security
	 */
	public $security;
	/**
	 * Input class
	 * @var CI_Input
	 */
	public $input;
	/**
	 * Language class
	 * @var CI_Lang
	 */
	public $lang;
	/**
	 * Loader class
	 * @var CI_Loader
	 */
	public $load;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */