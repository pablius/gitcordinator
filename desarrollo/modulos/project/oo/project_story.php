<?php
// story (status, relevance, estimate, demo, description, asigned_to created_by, datetime, sprint_id)  (PROJECT_ID?)
class project_story extends OOB_model_type
{

	static protected $public_properties = array(
	
		'id_state' 			=> 'object-project_story_status',
		'relevance' 		=> 'isClean,isInt',
		'id_project' 		=> 'object-project_project', // not needed really
		'id_sprint' 		=> 'object-project_sprint',
		'id_estimate'		=> 'object-project_story_estimate',
		'id_remaining'		=> 'object-project_story_estimate',
		'name'				=> 'isClean,isCorrectLength-1-300',
		'number'				=> 'isInt',
		'demo'				=> 'isClean,isCorrectLength-0-9999',
		'description'		=> 'isClean,isCorrectLength-0-9999',
		'id_asigned' 		=> 'object-project_person',
		'id_created' 		=> 'object-project_person',
		'date' 				=> 'object-Date',
		'array_tags' 		=> 'manyobjects-project_tag'

	); // property => constraints
	
	static protected $table = 'project_story';
	static protected $class = __CLASS__;	
	static $orders = array('relevance','number'); 
	
	// definimos los attr del objeto
	public $id_state;
	public $relevance;
	public $id_project;
	public $id_sprint;
	public $id_estimate;
	public $id_remaining;
	public $name;
	public $number;
	public $demo;
	public $description;
	public $id_asigned;
	public $id_created;
	public $date;
	public $array_tags = array();
	

	public function name()
	{
		return trim($this->get('name'));
	}
	
	public function number()
	{
		return $this->get('number');
	}
	
	public function asigned()
	{
		return $this->get('asigned'); // project_person::exists();
	}
	
	public function created()
	{
		return $this->get('created');
	}
	
	public function meta()
	{
		$return = '';
		$return .= $this->name();
		$return .= ' @' . $this->get('asigned')->name();
		
		if (count($tags = $this->tags()))
		{
			$tags = '#' . join(' #',$tags);
			$return .= ' ' . $tags;
		}

		return $return;
	}
	
	public function tags()
	{
		$return = array();
		if ($tags = project_tag::getRelated($this))
		{
			$i = 0;
			$return = array();
			foreach ($tags as $tag)
			{
				$return[$i] = $tag->name();
				$i++;
			}
		}
		return $return;
	}
	
	static public function number_constructor ($number, project_project $project)
	{
		global $ari;
		$string = $ari->db->qMagic($number);
		$id_project = $ari->db->qMagic($project->id());
		
		$result = static::getList(false, false, false, false, false, false, false, "AND number = $string and id_project = $id_project");
		
		if ($result != false && count($result) == 1)
		{
			return $result[0];
		}
		else
		{
			return false;
		}	
	}
	
	
	public function set_from_meta($string)
	{
		global $ari;
		$string = trim($string);
		
		if (strlen($string) < 5)
		{
			$ari->error()->addError('META_SHORT');
			return false;
		}
		
		$datos_string = explode(' ',$string);
		$tags = array();
		
		// check if there is a user
		$asigned_to = $ari->user;
		$user_count = 0;
		$twitter_user = '';
		foreach ($datos_string as $dato)
		{
			if (substr($dato,0,1) == '@')
			{
				$user_count++;
				$twitter_user = substr($dato,1,strlen($dato));
			}
			
			if (substr($dato,0,1) == '#')
			{
				$tags[] = substr($dato,1,strlen($dato));
			}
			
		}
		
		// only one user per story
		if ($user_count > 1)
		{
			$this->error()->addError('META_MULTIPLEUSERS');
			return false;
		}
		elseif ($user_count == 1 && $twitter_user != '')
		{
			
			if (($asigned_to = project_person::create_new_person($twitter_user,$this->get('sprint')->get('project'))) == false)
			{
				$ari->error()->addError('META_PERSON_FAIL');
				return false;
			}
		}
		else
		{
			$asigned_to = $this->get('asigned');
		}
		
		$string = str_replace('@'. $twitter_user,'',$string);
		foreach ($tags as $tag)
		{
			$string = str_replace('#'. $tag,'',$string);
		}
		
		$this->set('name',trim($string));
		$this->set('asigned',$asigned_to);
		
		return $tags;
		
	}
	
	
	static public function new_from_string($string, project_sprint $sprint)
	{
		global $ari;
		$ari->db->startTrans();
		$string = trim($string);
		
		if (strlen($string) < 5)
		{
			return false;
		}
		
		$datos_string = explode(' ',$string);
		$tags = array();
		
		// check if there is a user
		$asigned_to = $ari->user;
		$user_count = 0;
		$twitter_user = '';
		foreach ($datos_string as $dato)
		{
			if (substr($dato,0,1) == '@')
			{

				$user_count++;
				$twitter_user = substr($dato,1,strlen($dato));
			}
			
			if (substr($dato,0,1) == '#')
			{
				$tags[] = substr($dato,1,strlen($dato));
			}
			
		}
		
		// only one user per story
		if ($user_count > 1)
		{
			$ari->db->FailTrans();$ari->db->completeTrans();
			return false;
		}
		elseif ($user_count == 1 && $twitter_user != '')
		{
			
			if (($asigned_to = project_person::create_new_person($twitter_user,$sprint->get('project'))) == false)
			{
				$ari->db->FailTrans();$ari->db->completeTrans();
				return false;
			}
		}
		else
		{
			$asigned_to = project_person::exists($ari->user);		
		}
		
		// create object and save.
		$new_story = new project_story();
		$new_story->set('state',new project_story_status(1));
		// $new_story->set('relevance',1);
		
		$new_story->set('project',$sprint->get('project'));
		$new_story->set('sprint',$sprint);
		
		$new_story->set('estimate',new project_story_estimate(13));
		$new_story->set('remaining',new project_story_estimate(13));
		
		
		$string = str_replace('@'. $twitter_user,'',$string);
		foreach ($tags as $tag)
		{
			$string = str_replace('#'. $tag,'',$string);
		}
		
		$new_story->set('name',trim($string));

		$new_story->set('asigned',$asigned_to);
		$new_story->set('created',project_person::exists($ari->user));
		$new_story->set('date',new Date());
		
		// check if there are any tags

		if ($new_story->store())
		{
			// aca los tags
			foreach ($tags as $tag)
			{
				$new_tag = new project_tag();
				$new_tag->set ('tag',$tag);
				$new_tag->set ('project',$sprint->get('project'));
				$new_tag->set ('relacion',$new_story); /// y la magia donde está??
				$new_tag->store();
			}
			
			return $ari->db->completeTrans();
		}
		else
		{
			$ari->db->FailTrans();$ari->db->completeTrans();
			return false;
		}
		
	}
	
	public function store()
	{
		global $ari, $project;
		
		$ari->db->startTrans();
		
			
		if ($this->id === NULL)
		{
			$id_project = $ari->db->qMagic($project->id());
			$table = static::getTable();
			
			// get the previous number from the DB
			$sql = "SELECT MAX(number)
					FROM $table 
					WHERE
					id_project = $id_project
					AND status = '1'
				   ";
			
			$savem= $ari->db->SetFetchMode(ADODB_FETCH_NUM);
			$rs = $ari->db->Execute($sql); 
			$ari->db->SetFetchMode($savem);
				
			if ($rs && !$rs->EOF) 
			{ 
				$this->set('number', $rs->fields[0] + 1);
				$rs->Close();
			}
			else
			{
				$this->set('number',1);
			}
			
			// get the previous number from the DB
			$sql = "SELECT MAX(relevance)
					FROM $table 
					WHERE
					id_project = $id_project
					AND status = '1'
				   ";
			
			$savem= $ari->db->SetFetchMode(ADODB_FETCH_NUM);
			$rs = $ari->db->Execute($sql); 
			$ari->db->SetFetchMode($savem);
				
			if ($rs && !$rs->EOF) 
			{ 
				$this->set('relevance', $rs->fields[0] + 1);
				$rs->Close();
			}
			else
			{
				$this->set('relevance',1);
			}
			
			
		}
			
		if (!parent::store())
		{
			$ari->db->failTrans();
		}
		
		if ($ari->db->completeTrans())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	static public function getRelated($object, $count = false, $sort = false, $sort_mode=false)
	{
		// buscamos los datos del objeto
		global $ari;
		$valor = $ari->db->qMagic($object->id());
		$object_class = get_class($object);
				
		$our_class = static::getClass();
		
		$sql = false;
	
		foreach($our_class::$public_properties as $campo => $constraint)
		{
			// tiene que estar definido que hay relaciones multiples en nuestro objeto
			if (strcasecmp('object-' . $object_class,$constraint) == 0) //eregi('(^object-'.strtolower($object_class).')(.*)',strtolower($constraint)))
			{
				// pedimos un list de nuestros objetos que lo tengan a él como hijo
				$sql = "AND $campo = $valor";
			}
			elseif (strcasecmp('object-relation',$constraint) == 0)//(eregi('(^object-relation)(.*)',strtolower($constraint)))
			{
				// si las relaciones son del tipo "object-relation"
				$object_valor = $ari->db->qMagic($object_class);
				$object_campo = 'class' . substr($campo,2,strlen($campo));
				
				$sql = "AND $campo = $valor AND $object_campo = $object_valor ";				
			}
			
		}
		
		if ($sql != false)
		{
			if (!$count)
			{
				return static::getList(false, false, $sort, $sort_mode, false, false, false, $sql);
			}
			else
			{
				return static::getListCount(false, false, false, $sql);
			}
		}
		
		return false;		
	}
	
	
	static public function max_relevance_number(project_project $project)
	{
		global $ari;
		$id_project = $ari->db->qMagic($project->id());
		$table = static::getTable();
		$return = 0;
		
		// get the previous number from the DB
		$sql = "SELECT MAX(relevance)
				FROM $table 
				WHERE
				id_project = $id_project
				AND status = '1'
			   ";
		
		$savem= $ari->db->SetFetchMode(ADODB_FETCH_NUM);
		$rs = $ari->db->Execute($sql); 
		$ari->db->SetFetchMode($savem);
				
		if ($rs && !$rs->EOF) 
		{ 
			$return = $rs->fields[0];
			$rs->Close();
		}
		
		return $return;
	}

}
?>