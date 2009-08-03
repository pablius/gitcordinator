<?php
//project_importance_rate
class project_importance_rate extends OOB_model_type
{

	static protected $public_properties = array(
	
		'description' 		=> 'isClean,isCorrectLength-0-255',
		'value' 				=> 'isInt'
		
	); // property => constraints
	
	static protected $table = 'project_importance_rate';
	static protected $class = __CLASS__;	
	static $orders = array('description'); 
	
	// definimos los attr del objeto
	public $description;
	public $value;
}
?>


