<?php
// daily_scrum(sprint_id,date_time,user,yesterday,today,blocks)
class project_daily extends OOB_model_type
{

	static protected $public_properties = array(
	
		'id_sprint'		=> 'object-project_sprint',
		'date' 			=> 'object-Date',
		'id_person'		=> 'object-project_person',
		'yesterday'		=> 'isClean,isCorrectLength-0-999',
		'today'		=> 'isClean,isCorrectLength-0-999',
		'blocks'		=> 'isClean,isCorrectLength-0-999',
		
	); // property => constraints
	
	static protected $table = 'project_daily';
	static protected $class = __CLASS__;	
	static $orders = array('tag'); 
	
	// definimos los attr del objeto
	public $id_sprint;
	public $date;
	public $id_person;
	public $yesterday;
	public $today;
	public $blocks;
	
	// returns today daily scrum for a person
	static public function today(project_person $person, project_sprint $sprint)
	{
		global $ari;
		$id_person = $ari->db->qMagic($person->id());
		$date = $ari->db->qMagic(date('Y-m-d'));
			
		$result = static::getList(false, false, false, false, false, false, false, "AND id_person = $id_person and date = $date");
		
		if ($result != false && count($result) == 1)
		{
			return $result[0];
		}
		else
		{
			$new = new project_daily();
			$new->set('sprint',$sprint);
			$new->set('person',$person);
			$new->set('date',new Date());
			return $new;
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
		
		$date = $ari->db->qMagic($this->get('date')->format('%D'));		
		$id_sprint = $ari->db->qMagic($this->get('sprint')->id());		
		$id_person = $ari->db->qMagic($this->get('person')->id());
		
		if (static::getListCount(false, false, false, "AND date = $date AND id_sprint = $id_sprint AND id_person = $id_person $clausula") == 0)
		{
			return false;						
		}
		else
		{
			return true;
		}

	}
	
	
}
?>


