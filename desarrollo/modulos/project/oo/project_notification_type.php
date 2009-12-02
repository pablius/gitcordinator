<?php

class project_notification_type extends OOB_model_type
{

	static protected $public_properties = array(
	
		'style' 			=> 'isClean,isCorrectLength-1-255',
		
	); // property => constraints
	
	static protected $table = 'project_notification_type';
	static protected $class = __CLASS__;	
	static $orders = array('style');

	// definimos los attr del objeto
	public $style;

}
?>


