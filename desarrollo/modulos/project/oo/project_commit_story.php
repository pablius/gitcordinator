<?php
//project_commit_story
class project_commit_story extends OOB_model_type
{

	static protected $public_properties = array(
	
		'id_story' 		=> 'object-project_story',
		'id_commit' 		=> 'object-project_commit'
		
		
	); // property => constraints
	
	static protected $table = 'project_commit_story';
	static protected $class = __CLASS__;	
	static $orders = array('id_commit'); 
	
	// definimos los attr del objeto
	public $id_story;
	public $id_commit;
	
}
?>


