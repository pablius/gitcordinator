<?php
//project_story_relevance

class project_story_relevance extends OOB_model_type
{

	static protected $public_properties = array(
	
		'description' 		=> 'isClean,isCorrectLength-0-140',
		'value' 			=> 'isInt'
		
	); // property => constraints
	
	static protected $table = 'project_story_relevance';
	static protected $class = __CLASS__;	
	static $orders = array('description'); 
	
	// definimos los attr del objeto
	public $description;
	public $value;
}
?>


