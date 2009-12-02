<?php
//project_notification

class project_notification extends OOB_model_type
{

	static protected $public_properties = array(
	
		'text' 			=> 'isClean,isCorrectLength-0-255',
		'id_type' 		=> 'object-project_notification_type',
		'selfclear' 	=> 'isBool',
		'id_person' 	=> 'object-project_person'
		
	); // property => constraints
	
	static protected $table = 'project_notification';
	static protected $class = __CLASS__;	
	static $orders = array('text');
	
	protected $hard_delete = true;
	
	// definimos los attr del objeto
	public $text;
	public $id_type;
	public $id_person;
	public $selfclear;
	
	static public function clear (project_person $person)
	{
		global $ari;
		
		if ($notifications = project_notification::getRelated($person))
		{
			foreach ($notifications as $notification)
			{
				$notification->delete();
			}
		}
		return true;
	}
	
	static public function notify (project_person $person, $text, project_notification_type $type, $selfclear = true)
	{
		global $ari;
		
		if ($selfclear)
		{
			$selfclear = 1;
		}
		else
		{
			$selfclear  = 0;
		}
		
		static::clear($person);
			
		$new = new project_notification();
		$new->set('text',$text);
		$new->set('person',$person);
		$new->set('type',$type);
		$new->set('selfclear',$selfclear);
		
		return $new->store();
	}

}
?>


