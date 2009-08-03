<?php
//project_commit_file
class project_commit_file extends OOB_model_type
{

	static protected $public_properties = array(
	
		'file_name' 		=> 'isClean,isCorrectLength-0-999',
		'file_url' 			=> 'isClean,isCorrectLength-0-9999',
		'id_commit' 		=> 'object-project_commit'
		
		
	); // property => constraints
	
	static protected $table = 'project_commit_file';
	static protected $class = __CLASS__;	
	static $orders = array('file_name'); 
	
	// definimos los attr del objeto
	public $file_name;
	public $file_url;
	public $id_commit;
	
}
?>


