<?php
//project_sprint_speed

class project_sprint_speed extends OOB_model_type
{

	static protected $public_properties = array(
	
		'description' 		=> 'isClean,isCorrectLength-0-255',
		'days' 				=> 'isClean'
		
	); // property => constraints
	
	static protected $table = 'project_sprint_speed';
	static protected $class = __CLASS__;	
	static $orders = array('days','description');
	
	// definimos los attr del objeto
	public $description;
	public $days;
	
	public function name()
	{
		return $this->get('description');
	}
}
?>


