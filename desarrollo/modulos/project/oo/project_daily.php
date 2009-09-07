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
	public $id_user;
	public $yesterday;
	public $today;
	public $blocks;

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
		
		$date = $ari->db->qMagic($this->date);		
		$id_sprint = $ari->db->qMagic($this->id_sprint);		
		$id_user = $ari->db->qMagic($this->id_user);
		
		if (static::getListCount(false, false, false, "AND date = $date AND id_sprint = $id_sprint AND id_user = $id_user $clausula") == 0)
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


