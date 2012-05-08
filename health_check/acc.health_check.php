<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* 
TODO:
 - check for MSM
*/

/**
 * Health Check Accessory
 *
 * @package			Health Check
 * @version			0.1.4
 * @author			Jason Siffring <http://surprisehighway.com>
 * @copyright 	Copyright (c) 2010 Jason Siffring <http://surprisehighway.com>
 * @license 		http://creativecommons.org/licenses/by-nc-sa/3.0/ Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License
 */

class Health_check_acc {

	var $name         = 'Health Check';
	var $id           = 'health_check';
	var $version      = '0.1.4';
	var $description  = 'Displays information about the configuration and general health of your EE system. Useful for maintenance and troubleshooting. One possible use is to copy and paste the output into an EE or add-on support request so you can get help faster.';
	var $sections     = array();

	/**
	 * Constructor
	 */
	function Health_check_acc()
	{
		$this->EE =& get_instance();
		$this->CI =& get_instance(); // since we need to load CI libraries
	}
	
  /**
  * Set Sections
  *
  * Set content for the accessory
  *
  * @access	public
  * @return	void
  */

	function set_sections()
	{  

	    // add our CSS file to the CP
	    $css_file = $this->EE->config->item('theme_folder_url') . 'third_party/health_check/healthcheck.css';
	    $this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" media="all" href="' . $css_file . '" />');
	    
		// setup the accessory sections
		$this->sections['Status']  = $this->EE->load->view('status', $this->_check_status(), TRUE);
		$this->sections['Status'] .= $this->EE->load->view('addons', $this->_list_addons(), TRUE);
		$this->sections['Status'] .= $this->EE->load->view('filemanager', $this->_get_file_upload_paths(), TRUE);
		$this->sections['Status'] .= $this->EE->load->view('sys_info', $this->_system_info(), TRUE);
	}


	function _get_file_upload_paths()
	{
		$dirs = array();

		$this->EE->load->model('file_upload_preferences_model');
		
		if (method_exists($this->EE->file_upload_preferences_model, 'get_file_upload_preferences')) {
			// for ee 2.4 and newer
			$dirs = $this->EE->file_upload_preferences_model->get_file_upload_preferences($this->EE->session->userdata('group_id'));
		} else {
			// for older than ee 2.4
			$query = $this->EE->file_upload_preferences_model->get_upload_preferences($this->EE->session->userdata('group_id'));
			foreach($query->result_array() as $dir)
			{
				$dirs[$dir['id']] = $dir;
			}
		}

		ksort($dirs);

		$vars['file_uploads'] = $dirs;
		return $vars;

	}
  // --------------------------------------------------------------------
  // Check EE Version
  // Looks to see if there is a newer build or version of EE
  //
  function _system_info()
  {  
    // get the latest available version and build of EE
    $latest = $this->_fetch_version();
    $vars = array(
      "latest_ee_version" => $latest['version'],
      "latest_ee_build"   => $latest['build'],
    );
    
    if (file_exists(APPPATH . 'libraries/Sites.php')) {
      $vars['ee_msm'] = "installed";
    } else {
      $vars['ee_msm'] = "not installed";
    }
    
    // are extensions installed?
    if ($this->EE->config->item('allow_extensions') == 'y') {
      $vars['ee_extensions'] = "installed";
    } else {
      $vars['ee_extensions'] = "not installed";
    }
    
    // get the MySQL version
    $vars['mysql_version'] = $this->EE->db->version();
    
    // get the jquery version
    $contents = file_get_contents(PATH_JQUERY.'jquery.js', NULL, NULL, 0, 100); // get the first 100 characters 
    $start = strpos($contents, 'jQuery JavaScript Library v');
    $vars['jquery_version'] = substr($contents, $start + 27, 5); 
    
    // get some EE stats
    $this->CI->load->database();
    $query = $this->CI->db->query('SELECT count(*) AS count FROM exp_sites');
    $row = $query->row();
    $vars['ee_sites'] = $row->count;
    
    $query = $this->CI->db->query('SELECT count(*) AS count FROM exp_channels');
    $row = $query->row();
    $vars['ee_channels'] = $row->count;

    $query = $this->CI->db->query('SELECT count(*) AS count FROM exp_channel_titles');
    $row = $query->row();
    $vars['ee_entries'] = $row->count;
    
    $query = $this->CI->db->query("SHOW TABLES LIKE 'exp_comments'");
    if ($query->num_rows() > 0) {
      $query = $this->CI->db->query('SELECT count(*) AS count FROM exp_comments');
      $row = $query->row();
      $vars['ee_comments'] = $row->count;
    } else {
      // comment module isn't installed
      $vars['ee_comments'] = "not installed";
    }
    
    // get some php info
    $vars['php']['version'] = phpversion();
    
    if (ini_get('register_globals')) {
      $register_globals = "on";
    } else {
      $register_globals = "off"; 
    }
    $vars['php']['register_globals'] = $register_globals;
    
    if (ini_get('safe_mode')) {
      $safe_mode = "on";
    } else {
      $safe_mode = "off"; 
    }
    $vars['php']['safe_mode'] = $safe_mode;
    $vars['php']['open_basedir'] = ini_get('open_basedir');
    $vars['php']['max_execution_time'] = ini_get('max_execution_time');
    $vars['php']['upload_max_filesize'] = ini_get('upload_max_filesize');
    $vars['php']['max_input_time'] = ini_get('max_input_time');
    $vars['php']['memory_limit'] = ini_get('memory_limit');
    
    // is the session save path writable?
    if (session_save_path() == '') {
    	$vars['php']['session_save_path'] = 'not set';
    } else {
	    if (@is_writable(session_save_path())) {
	      $vars['php']['session_save_path'] = 'writable';
	    } else {
	      $vars['php']['session_save_path'] = 'not writable';
	    }
	}

    // browser info
    $this->CI->load->library('user_agent');
    $vars['browser'] = $this->CI->agent->browser().' '.$this->CI->agent->version();
    $vars['platform'] = $this->CI->agent->platform(); 
    
    // server info 
    $vars['webserver'] = $_SERVER["SERVER_SOFTWARE"];

    return $vars;
  }
  
  // --------------------------------------------------------------------
  // Lists all currently installed add-ons
  //
  function _list_addons()
  {
    //$this->EE->load->model('addons_model');
    $this->EE->load->library('addons');
    
    $vars = array(
      'modules'     => $this->EE->addons->get_installed('modules'),
      'accessories' => $this->EE->addons->get_installed('accessories'),
      'extensions'  => $this->EE->addons->get_installed('extensions'),
      'fieldtypes'  => $this->EE->addons->get_installed('fieldtypes'),
    );

	// get plugins if we're not on the CP's plugin page
	// yeah, nasty hack, bt the darn addon mdoel won't let you get_plugins() more than once
	if (isset($_GET['C']) && isset($_GET['D']) && $_GET['C'] == 'addons_plugins' && $_GET['D'] == 'cp')
	{
		$vars['plugins'][] = array(
			'pi_name' => "We can't display plugins<br/> on this page due to<br/> a limitation in EE.",
			'pi_version' => ""
			);
	} else {
		$vars['plugins'] = $this->EE->addons_model->get_plugins();
	}

    ksort($vars['modules']);
	ksort($vars['accessories']);
	ksort($vars['extensions']);
	ksort($vars['fieldtypes']);
	ksort($vars['plugins']);

    return($vars);
  }
  
  // --------------------------------------------------------------------
  // Check file permissions, etc.
  //
  function _check_status()
  {
   
	$vars = array();
	$vars['errors'] = array(); // store our errors here

    // an array of files or directories and the required permission for each
    $files = array(
      APPPATH . 'config/config.php' => decoct(FILE_WRITE_MODE),
      APPPATH . 'config/database.php' => decoct(FILE_WRITE_MODE),
      APPPATH . 'cache' => decoct(DIR_WRITE_MODE)
      
    );    
    // check each file to see if they have the right permission
    foreach($files as $file => $perm) {
      if (substr(sprintf('%o', fileperms($file)), -3) != $perm) { // get the 4 digit permission for the file and compare it to the required permission
        $lastslash = strrpos($file, "/"); // get position of last slash
        $filename = substr($file, $lastslash + 1, strlen($file)); // get string from last slash to the end
        $vars['errors']["{$filename} permission should be {$perm}"] = "chmod {$perm} {$file}"; 
      }
    }
    
    // check if save_session_path is writable
    if (!@is_writable(session_save_path())) {
      $vars['errors']["Your PHP session_save_path is not writable"] = "chmod ". decoct(DIR_WRITE_MODE) ." " . session_save_path();
    }
    
    // check if extensions are installed
    if ($this->EE->config->item('allow_extensions') != 'y') {
      $vars['errors']["EE extensions are not allowed."] = 'Set $config["allow_extensions"] = "y"; in /system/expressionengine/config/config.php';
    }

    // check if upload directories are writable
    $dirs = $this->_get_file_upload_paths();
    $dirs = $dirs['file_uploads'];

    foreach ($dirs as $key => $dir)
    {
    	if (!@is_writable($dir['server_path'])) {
    		$vars['errors']["The " . $dir['name'] . " file upload directory is not writable"] = "chmod ". decoct(DIR_WRITE_MODE) ." " . $dir['server_path'];
    	}
    }

    // watch out for open_basedir
	if (ini_get('open_basedir') != '')
	{
		$vars['errors']["PHP is using open_basedir restrictions, so we may have trouble detecting if file upload directories are not writable."] = "consider disabling PHP open_basedir in php.ini ";	}

	if ( isset($vars['errors']) && count($vars['errors']) > 0 )
	{
		$this->name = $this->name . '<span class="health_check_badge">' . count($vars['errors']) . '</span>';
	}

    return $vars; 
  }


	// --------------------------------------------------------------------
  // I borrowed these from acc.expressionengine_info.php. Thanks @EllisLab.
  //
	/**
	 * Fetch Version
	 *
	 * @access	public
	 * @return	string
	 */
	function _fetch_version()
	{
		// check cache first
		$cache_expire = 60 * 60 * 24;	// only do this once per day
		
		$this->EE->load->helper('file');	
		$contents = read_file(APPPATH.'cache/health_check/version');

		if ($contents !== FALSE)
		{
			$details = unserialize($contents);
			if (isset($details['timestamp'])) 
			{
				if (($details['timestamp'] + $cache_expire) > $this->EE->localize->now)
				{
					if (isset($details['error']))
					{
						return $details['error'];
					}
					else
					{
						//return str_replace(array('%v', '%b'), array($details['version'], $details['build']), $this->EE->lang->line('version_info'));
						return $details;
					}
				}
			}
			else
			{
				return $details['error'];
			}
		}
		
		// no cache, so get current downloadable version
		$version = $this->_fsockopen_process('http://expressionengine.com/eeversion2.txt');
		
		$version = trim(str_replace('Version:', '', $version));
		
		$build = $this->_fsockopen_process('https://secure.expressionengine.com/extra/ee_current_build/v2');

		$details = array(
							'timestamp'	=> $this->EE->localize->now,
							'version'	=> $version,
							'build'		=> $build
						);

		$this->_write_cache($details);
		//return str_replace(array('%v', '%b'), array($details['version'], $details['build']), $this->EE->lang->line('version_info'));
		return $details;
	}

	// --------------------------------------------------------------------
	
	/**
	 * fsockopen process
	 *
	 * Someday I'll write a proper Connection library
	 *
	 * @access	public
	 * @param	string	url
	 * @return	string
	 */
	function _fsockopen_process($url)
	{
		$parts	= parse_url($url);
		$host	= $parts['host'];
		$path	= ( ! isset($parts['path'])) ? '/' : $parts['path'];
		$port	= ($parts['scheme'] == "https") ? '443' : '80';
		$ssl	= ($parts['scheme'] == "https") ? 'ssl://' : '';

		$ret = '';

		$fp = @fsockopen($ssl.$host, $port, $error_num, $error_str, 4); 

		if (is_resource($fp))
		{
			fwrite($fp,"GET {$path} HTTP/1.0\r\n" );
			fwrite($fp,"Host: {$host}\r\n" );
			fwrite($fp,"User-Agent: EE/EllisLab PHP/\r\n\r\n");
			
			// There is evidently a bug in PHP < 5.2 with SSL and fsockopen() when the $length is
			// greater than the remaining data - so distasteful as it is, we'll suppress errors
			while($datum = @fread($fp, 4096))
			{
				$ret .= $datum;
			}

			@fclose($fp); 
		}
		else
		{
			$this->_write_cache(array('error' => 'error_getting_version'));
			return 'error_getting_version';
		}

		// and get rid of headers
		if ($pos = strpos($ret, "\r\n\r\n"))
		{
			$ret = substr($ret, $pos);
		}
		
		return trim($ret);
	}

	// --------------------------------------------------------------------

	/**
	 * Write Cache
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	function _write_cache($details)
	{
		if ( ! is_dir(APPPATH.'cache/health_check'))
		{
			mkdir(APPPATH.'cache/health_check', DIR_WRITE_MODE);
			@chmod(APPPATH.'cache/health_check', DIR_WRITE_MODE);
		}
		
		if (write_file(APPPATH.'cache/health_check/version', serialize($details)))
		{
			@chmod(APPPATH.'cache/health_check/version', FILE_WRITE_MODE);			
		}
	}

	// --------------------------------------------------------------------
		
}
// END CLASS
