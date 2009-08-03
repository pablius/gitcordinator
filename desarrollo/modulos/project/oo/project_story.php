<?php
// story (status, relevance, estimate, demo, description, asigned_to created_by, datetime, sprint_id)  (PROJECT_ID?)
class project_story extends OOB_model_type
{

	static protected $public_properties = array(
	
		'id_status' 		=> 'object-project_story_status',
		'relevance' 		=> 'isClean,isInt',
		'id_project' 		=> 'object-project_project', // not needed really
		'id_sprint' 		=> 'object-project_sprint',
		'estimate'			=> 'isClean,isFloat',
		'name'				=> 'isClean,isCorrectLength-0-300',
		'demo'				=> 'isClean,isCorrectLength-0-9999',
		'description'		=> 'isClean,isCorrectLength-0-9999',
		'id_asigned' 		=> 'object-oob_user',
		'id_created' 		=> 'object-oob_user',
		'date' 				=> 'object-Date',
		'array_tags' 		=> 'manyobjects-project_tag'

	); // property => constraints
	
	static protected $table = 'project_story';
	static protected $class = __CLASS__;	
	static $orders = array('start','goal'); 
	
	// definimos los attr del objeto
	public $id_status;
	public $id_relevance;
	public $id_project;
	public $id_sprint;
	public $estimate;
	public $name;
	public $demo;
	public $description;
	public $id_asigned;
	public $id_created;
	public $date;
	public $array_tags = array();
	

	public function name()
	{
		return $this->get('name');
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
			else
			{
				$asigned_to = $asigned_to->get('user');
			}
		}
		
	
		
		// create object and save.
		$new_story = new project_story();
		$new_story->set('status',new project_story_status(1));
		$new_story->set('relevance',1);
		
		$new_story->set('project',$sprint->get('project'));
		$new_story->set('sprint',$sprint);
		
		$new_story->set('estimate',1);
		$new_story->set('name',str_replace('#','',str_replace($tags,'',str_replace('@'. $twitter_user,'',$string))));
		$new_story->set('sprint',$sprint);
		$new_story->set('asigned',$asigned_to);
		$new_story->set('created',$ari->user);
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

}
?>