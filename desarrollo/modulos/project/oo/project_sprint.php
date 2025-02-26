<?php
// sprint (id, fecha_inicio, fecha_cierre, project_id, goal => text, eval_meeting_result => TEXT)
class project_sprint extends OOB_model_type
{

	static protected $public_properties = array(
	
		'start' 					=> 'object-Date',
		'finish' 					=> 'object-Date',
		'id_project' 				=> 'object-project_project',
		'goal'						=> 'isClean,isCorrectLength-1-9999',
		'eval_meeting_result'		=> 'isClean,isCorrectLength-0-9999',
		'id_kind'					=> 'object-project_sprint_kind',
		'number'					=> 'isInt',
		'array_stories'				=> 'manyobjects-project_story'

	); // property => constraints
	
	static protected $table = 'project_sprint';
	static protected $class = __CLASS__;	
	static $orders = array('start','goal','finish','id'); 
	
	// definimos los attr del objeto
	public $start;
	public $finish;
	public $id_project;
	public $goal;
	public $eval_meeting_result;
	public $id_kind;
	public $number;
	
	public $array_stories = array();
	
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
		
		$id_project = $ari->db->qMagic($this->get('project')->id());
		$id_kind = $ari->db->qMagic($this->get('kind')->id());
		$number = $ari->db->qMagic($this->get('number'));
		$start = $ari->db->qMagic($this->get('start')->format('%Y-%m-%d'));	
		
		if (static::getListCount(false, false, false, "AND id_project = $id_project AND number = $number AND id_kind = $id_kind $clausula") == 0) // AND start  = $start
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
		return $this->get('goal');
	}
	
	public function number()
	{
		if ($this->id_kind != 1)
		{
			return $this->get('kind')->name(); 
		}
		else
		{
			return $this->get('number'); 
		}
	}
	
	public function total_estimate()
	{
		global $ari;
		$return = 0;
		if ($stories = $this->get('stories'))
		{
			foreach ($stories as $story)
			{
				$return += $story->get('estimate')->get('value');
			}
		}
		
		return $return;
	}
	
	/*public function isValid()
	{
		
		if ($this->get('number') == '')
		{
			$this->set('number',$this->get('project')->current_sprint()->get('number') + 1);
		}
		
		return static::isValid();
	
	}*/

}
?>