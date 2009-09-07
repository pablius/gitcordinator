<?php
//project_story_estimate

class project_story_estimate extends OOB_model_type
{

	static protected $public_properties = array(
	
		'description' 		=> 'isClean,isCorrectLength-0-140',
		'value' 			=> 'isInt'
		
	); // property => constraints
	
	static protected $table = 'project_story_estimate';
	static protected $class = __CLASS__;	
	static $orders = array('description'); 
	
	// definimos los attr del objeto
	public $description;
	public $value;
}
?>


