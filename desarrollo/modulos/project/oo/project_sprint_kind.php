<?php
//project_sprint_speed

class project_sprint_kind extends OOB_model_type
{

	static protected $public_properties = array(
	
		'description' 		=> 'isClean,isCorrectLength-0-255'
		
	); // property => constraints
	
	static protected $table = 'project_sprint_kind';
	static protected $class = __CLASS__;	
	static $orders = array('description');
	
	// definimos los attr del objeto
	public $description;

}
?>


