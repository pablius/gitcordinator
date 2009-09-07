<?php
// project (nombre, sprint_speed, importance_rate, url_svn, manager)
class project_project extends OOB_model_type
{

	static protected $public_properties = array(
	
		'name' 					=> 'isClean,isCorrectLength-1-255',
		'id_sprint_speed' 		=> 'object-project_sprint_speed',
		'url_repo'				=> 'isClean,isCorrectLength-1-500',
		'id_repo'				=> 'object-project_repository_type',
		'id_user'				=> 'object-oob_user'


	); // property => constraints
	
	static protected $table = 'project_project';
	static protected $class = __CLASS__;	
	static $orders = array('nombre'); 
	
	// definimos los attr del objeto
	public $name;
	public $id_sprint_speed;
	public $url_repo;
	public $id_repo;
	public $id_user;
	
	static public function url_detect($url)
	{
		global $ari;
		
		// volvemos a poner el url en el original.. lo vamos a cambiar de nuevo mas adelante, solo si le corresponde.
		$ari->webaddress= $ari->config->get('webaddress', 'location');
		
		// aca va la logica que lleva al usuario al projecto que corresponde, si no hay proyecto lo lleva a singup.
		$project_url = str_replace('.clarisapp.com','',$_SERVER['SERVER_NAME']);
		
		
		if (in_array($project_url,array('www','beta','admin','clarisapp.com')))
		{
			if ($url[0] == 'setup' && $ari->module->name() == 'project')
			{
				// default perspective is needed.
				$ari->perspective = new oob_perspective ('default');
				return new project_project();
			}
			else
			{
				header( "Location: " . $ari->get('webaddress') . '/project/setup/1');
				exit;
			}
		}
		
		if ($project = static::project_from_url($project_url))
		{
			// seteamos el webaddress con el del project para corregir todos los urls mal que puedan existir
			$ari->webaddress = 'http://' . $project->get('url_repo') . '.clarisapp.com';
			
			// si es setup 1 o 2, lo mandamos al dashboard
			if ($url[0] == 'setup' && $ari->module->name() == 'project' && isset($url[1]) && ($url[1] == '1' || $url[1] == '2'))
			{
				header( "Location: " . $ari->get('webaddress') . '/project/dashboard');
				exit;
			}
			
			// si viene de main, y es setup 3, lo dejamos 
			
			// si es setup 3, no tiene que tener header todavia
			if ($url[0] == 'setup' && $ari->module->name() == 'project' && isset($url[1]) && $url[1] == '3')
			{
				
				if (!in_array($_SERVER['HTTP_REFERER'],array
															(
																'http://www.clarisapp.com/project/setup/2',
																'http://clarisapp.com/project/setup/2',
																'http://beta.clarisapp.com/project/setup/2',
																$ari->webaddress.'/project/setup/3',
															)
					))
				{

					header( "Location: " . $ari->get('webaddress') . '/project/dashboard');
					exit;
				}
			
				$ari->perspective = new oob_perspective ('default');
				
			}

			return $project;
		}
		else
		{
			header( "Location: " . $ari->get('webaddress') . '/project/setup/1');
			exit;
		}		
	
	}
	
	static private function project_from_url($url)
	{
		global $ari;
		$url = $ari->db->qMagic($url);	

		$result = static::getList(false, false, false, false, false, false, false, "AND url_repo = $url ");
		
		if (count($result) == 1)
		{
			return $result[0];				
		}
		else
		{
			return false;
		}
		
		
	}
	
	protected  function isDuplicated()
	{
		
		global $ari;
		$id = $this->id;
		 
		if ($id < ID_UNDEFINED) 					
		{	
			$clausula = "";
		}
		else
		{	
			$clausula = " AND id <> $id ";	
		}
		
		$url_repo = $ari->db->qMagic($this->url_repo);		
		
		if (static::getListCount(false, false, false, "AND url_repo = $url_repo $clausula") == 0)
		{
			return false;						
		}
		else
		{
			return true;
		}

	}
	

	public function name()
	{
		return $this->get('name');
	}

	/* capaz que esto tenga que ir en sprint no? */
	public function current_sprint()
	{
		global $ari;
		
		$id_project = $ari->db->qMagic($this->id());
		$actual_sprint = project_sprint::getList(false, 1, 'id', DESC, false, false, false, "AND id_project = $id_project AND id_kind = 1");
		
		return $actual_sprint[0];
	}
	
	public function product_backlog()
	{
		global $ari;
		
		$id_project = $ari->db->qMagic($this->id());
		$product_backlog = project_sprint::getList(false, 1, 'id', DESC, false, false, false, "AND id_project = $id_project AND id_kind = 2");
		
		return $product_backlog[0];
	}
	
	public function unplaned()
	{
		global $ari;
		
		$id_project = $ari->db->qMagic($this->id());
		$unplaned = project_sprint::getList(false, 1, 'id', DESC, false, false, false, "AND id_project = $id_project AND id_kind = 3");
		
		return $unplaned[0];
	}
	
}
?>

