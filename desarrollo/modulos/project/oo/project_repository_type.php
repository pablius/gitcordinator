<?php
//project_repository_type
class project_repository_type extends OOB_model_type
{

	static protected $public_properties = array(
	
		'description' 		=> 'isClean,isCorrectLength-0-255'
		
	); // property => constraints
	
	static protected $table = 'project_repository_type';
	static protected $class = __CLASS__;	
	static $orders = array('description'); 
	
	// definimos los attr del objeto
	public $description;
}
?>


