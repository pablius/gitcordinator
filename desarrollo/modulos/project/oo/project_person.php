<?php
// person (twitter, minibio, web, user_id, project_id)
class project_person extends OOB_model_type
{

	static protected $public_properties = array(
	
		'twitter_user' 			=> 'isClean,isCorrectLength-1-255',
		'added' 				=> 'object-Date',
		'bio'					=> 'isClean,isCorrectLength-0-500',
		'url' 					=> 'isClean,isCorrectLength-0-500',
		'picture' 				=> 'isClean,isCorrectLength-0-500',
		'id_user'				=> 'object-oob_user',
		'id_project'			=> 'object-project_project',
		'array_stories'			=> 'manyobjects-project_story',
		'array_tags'			=> 'manyobjects-project_tag'
		

	); // property => constraints
	
	static protected $table = 'project_person';
	static protected $class = __CLASS__;	
	static $orders = array('twitter_user','bio'); 
	
	// definimos los attr del objeto
	public $twitter_user;
	public $added;
	public $bio;
	public $url;
	public $picture;
	public $id_user;
	public $id_project;
	
	
	static public function create_new_person($twitter_user, project_project $project)
	{
		global $ari;
		// we check if there is an user with that twitter_user in the project, if so, return that user, else, create a new one, and return.
		$string = $ari->db->qMagic($twitter_user);
		$id_project = $ari->db->qMagic($project->id());
		
		$result = static::getList(false, false, false, false, false, false, false, "AND twitter_user = $string and id_project = $id_project");
		
		if ($result != false && count($result) == 1)
		{
			return $result[0];
		}
		else
		{
			// vemos si hay otro oob_user, que comparta ese registro de twitter, y si es así, lo linkeamos a ese oob_user en vez de crear otro.
			$result = static::getList(false, false, false, false, false, false, false, "AND twitter_user = $string and id_project != $id_project");
			if ($result != false)
			{
				$new_user = $result[0]->get('user');
			}
			else
			{
				// create a user with 
				$new_user = new oob_user ();
				$new_user->set('uname',$twitter_user . '-' . $project->id());
				$new_user->set('email',$twitter_user . '@pending.mail');
				$new_user->set('password',date('Ymd'));
				
				// capaz q acá no tenga que estar en estado enabled de arranque...
				$new_user->set('status',1);
				if ($new_user->store())
				{
					$new_user->linkStandardGroup();
				}
			}
					
			
			if (!count($new_user->error()->getErrors()))
			{
				// create project_person
				$new_person = new project_person();
				$new_person->set('twitter_user',$twitter_user);
				$new_person->set('added',new Date());
				$new_person->set('user',$new_user);
				$new_person->set('project',$project);
				
				if ($new_person->store())
				{
					return $new_person;
				}				
			}
			
			return false;
		}
		
	}
	
	
	static public function exists(oob_user $user)
	{
		global $ari;
			
		$string = $ari->db->qMagic($user->id());
		
		if (count($result = static::getList(false, false, false, false, false, false, false, "AND id_user = $string")) == 1)
		{
			return $result[0];
		}
		else
		{
			return false;
		}
	}
	
	protected  function isDuplicated()
	{
		
		global $ari;
		$id = $this->id;
		 
		if ($id < ID_UNDEFINED) 					
		{	
			$clausula = "";
		}
		else
		{	
			$clausula = " AND id <> $id ";	
		}
		
		$twitter_user = $ari->db->qMagic($this->twitter_user);		
		$id_project = $ari->db->qMagic($this->id_project);		
		
		if (static::getListCount(false, false, false, "AND twitter_user = $twitter_user AND id_project = $id_project $clausula") == 0)
		{
			return false;						
		}
		else
		{
			return true;
		}

	}

	public function delete()
	{
		// we delete the oob_user first
		$this->get('user')->delete();
		
		return parent::delete();
		
	}
	

	public function name()
	{
		return $this->get('twitter_user');
	}
			
	private function _send_mail($title,$template)
	{
		global $ari;
		
		$plantilla = $ari->newTemplate();
		$plantilla->caching = 0; 
		
		$from_address = $ari->config->get('email', 'main');
		$from_name = $ari->config->get('name', 'main');
		
		$user = $this->get('user');

		$to_address = $user->get('email');
		$to_name = $this->name();
	
		$plantilla->assign('name' ,$this->name());
		$plantilla->assign('project',$this->get('project')->name());
		
		// datos del usuario
		$plantilla->assign('user',$user->get('uname'));
		$plantilla->assign('email',$user->get('email'));
		
		
		//////////// mail send
		require_once ($ari->get('enginedir').DIRECTORY_SEPARATOR .'librerias'.DIRECTORY_SEPARATOR.'mimemessage'.DIRECTORY_SEPARATOR.'smtp.php');
		require_once ($ari->get('enginedir').DIRECTORY_SEPARATOR .'librerias'.DIRECTORY_SEPARATOR.'mimemessage'.DIRECTORY_SEPARATOR.'email_message.php');
		require_once ($ari->get('enginedir').DIRECTORY_SEPARATOR .'librerias'.DIRECTORY_SEPARATOR.'mimemessage'.DIRECTORY_SEPARATOR.'smtp_message.php');
		$email_message=new smtp_message_class;
		$email_message->localhost="";
		$email_message->smtp_host=$ari->config->get('delivery', 'main');
		$email_message->smtp_direct_delivery=0;
		$email_message->smtp_exclude_address="";
		$email_message->smtp_user="";
		$email_message->smtp_realm="";
		$email_message->smtp_workstation="";
		$email_message->smtp_password="";
		$email_message->smtp_pop3_auth_host="";
		$email_message->smtp_debug=0;
		$email_message->smtp_html_debug=1;
	
		$email_message->SetEncodedEmailHeader("To", $to_address,'"'.$to_name.'" <' . $to_address .'>'); 
		$email_message->SetEncodedEmailHeader("Cc",$from_address,'"'.$from_name.'" <' . $from_address .'>'); 
		$email_message->SetEncodedEmailHeader("From", $from_address,'"'.$from_name.'" <' . $from_address .'>'); 
		$email_message->SetEncodedHeader("Subject", $from_name . ' - ' . $title);
		$email_message->AddQuotedPrintableHTMLPart($plantilla->fetch($ari->module->usertpldir(). DIRECTORY_SEPARATOR . $template));
		

		return $email_message->Send();
	}
	
	public function send_mail_invite()
	{
		return $this->_send_mail('You\'ve been invited to join a project', "mail_invite.tpl");
	}
	
	static public function project_tag_cloud(project_project $project)
	{
		global $ari;
		// return is as follows => name,count,size
		$output = array();
		$return = array();
		$global_count = 0;
		
		if ($people = project_person::getRelated($project))
		{
			foreach ($people as $person)
			{
				$filtros = array();
				$filtros[] = array("field"=>"status","type"=>"list","value"=>1);
				$filtros[] = array("field"=>"project","type"=>"list","value"=>$project->id());
				$filtros[] = array("field"=>"asigned","type"=>"list","value"=>$person->id());
				
				$name = $person->name();
				$count = project_story::getFilteredListCount($filtros);
				
				if ((float)$count > (float)$global_count)
				{
					
					$global_count = $count;
				}
				
				$return[$name]['name'] = $name;
				$return[$name]['count'] = $count;
			}
			
			// sorted alfabetically
			ksort ($return);
			
			foreach ($return as $key => $data)
			{
				
				$relative_count = ($data['count'] / $global_count) * 100;
				
				
				if ($relative_count >= 0 && $relative_count < 20)
				{
					$size = 'x-small';
				}elseif($relative_count >= 20 && $relative_count < 40)
				{
					$size = 'small';
				}elseif($relative_count >= 40 && $relative_count < 60)
				{
					$size = 'medium';
				}elseif($relative_count >= 60 && $relative_count < 80)
				{
					$size = 'large';
				}else
				{
					$size = 'x-large';
				}
				
				$output[] = array ('name' => $key, 'count' => $data['count'], 'size' => $size);
			}
			
		
		}
		
		return $output;
	}

}
?>