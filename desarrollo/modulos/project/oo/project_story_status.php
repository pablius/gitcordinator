<?php
//project_story_status

class project_story_status extends OOB_model_type
{

	static protected $public_properties = array(
	
		'description' 		=> 'isClean,isCorrectLength-0-140',
		
	); // property => constraints
	
	static protected $table = 'project_story_status';
	static protected $class = __CLASS__;	
	static $orders = array('description'); 
	
	// definimos los attr del objeto
	public $description;
}
?>


