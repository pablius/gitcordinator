<?php
// comment (usr, msg,file,line,history)
class project_comment extends OOB_model_type
{

	static protected $public_properties = array(
	
		'id_user' 					=> 'object-oob_user',
		'message' 					=> 'isClean,isCorrectLength-0-9999',
		'id_story' 					=> 'object-project_story',
		'line'						=> 'isClean,isInt',
		'id_file'					=> 'object-project_commit_file',
		'date'						=> 'object-Date'

	); // property => constraints
	
	static protected $table = 'project_comment';
	static protected $class = __CLASS__;	
	static $orders = array('message','date'); 
	
	// definimos los attr del objeto
	public $id_user;
	public $message;
	public $id_story;
	public $line;
	public $id_file;
	public $date;
	

	public function name()
	{
		return $this->get('message');
	}

}
?>