<?php
// commit (id, commit_nr, date, msg, user, project_id)
class project_commit extends OOB_model_type
{

	static protected $public_properties = array(
	
		'number' 			=> 'isClean,isCorrectLength-0-255',
		'id_project'		=> 'object-project_project',
		'date'				=> 'object-Date',
		'message'			=> 'isClean,isCorrectLength-0-9999',
		'id_person'				=> 'object-project_person'
		
	); // property => constraints
	
	static protected $table = 'project_commit';
	static protected $class = __CLASS__;	
	static $orders = array('number','message'); 
	
	// definimos los attr del objeto
	public $number;
	public $id_project;
	public $date;
	public $message;
	public $id_person;
	
	
}
?>


