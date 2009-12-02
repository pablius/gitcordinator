<?php
// person (twitter, minibio, web, user_id, project_id)
class project_person extends OOB_model_type
{

	static protected $public_properties = array(
	
		'twitter_user' 			=> 'isClean,isCorrectLength-2-255',
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
	
	public $array_stories = array();
	public $array_tags = array();
	
	// magic user to have unasigned 
	public function __construct ($id = ID_UNDEFINED)
	{
		global $project;
		if ($id < 1)
		{
			$this->set('twitter_user','unassigned');
			$this->set('project',$project);
			$this->id = -1;
			$this->status = 1;
		}
		else
		{
			parent::__construct($id);
		}
	}
	
	
	static public function from_name($twitter_user, project_project $project)
	{
		global $ari;
		// we check if there is an user with that twitter_user in the project, if so, return that user, else, create a new one, and return.
		
		if ($twitter_user == 'unassigned')
		{
			return new project_person (-1);
		}
		
		$string = $ari->db->qMagic($twitter_user);
		$id_project = $ari->db->qMagic($project->id());
		
		$result = static::getList(false, false, false, false, false, false, false, "AND twitter_user = $string and id_project = $id_project");
		
		if ($result != false && count($result) == 1)
		{
			return $result[0];
		}
		else
		{
			return false;
		}
	}
	
	// @optmize (certain cases of string might not get linked)
	static public function link_people($string, project_project $project)
	{
		global $ari;
		$string_array = explode(' ', $string);
		$public_url = $project->public_url();
		$i = 0;
		foreach ($string_array as $possible)
		{
			if (substr($possible,0,1) == '@')
			{
				if ($person = static::from_name(substr($possible,1,strlen($possible)),$project))
				{	
					$name = $person->name();
					$string_array[$i] = "<a href=\"{$public_url}/project/browse/person/{$name}\">@{$name}</a>";
				}
			}
			$i++;
		}
		
		return implode (' ',$string_array);
	}
	
	static public function create_new_person($twitter_user, project_project $project)
	{
		global $ari;
		// we check if there is an user with that twitter_user in the project, if so, return that user, else, create a new one, and return.
		$string = $ari->db->qMagic($twitter_user);
		$id_project = $ari->db->qMagic($project->id());
	
		
		if ($result = project_person::from_name($twitter_user, $project))
		{
			return $result;
		}
		else
		{
			// if it does not validate as an email addres, its probably misstiped.
			if (!oob_validatetext::isEmail($twitter_user . '@fake.mail'))
			{
				return false;
			}
		
			// create project_person
			$new_person = new project_person();
			$new_person->set('twitter_user',$twitter_user);
			$new_person->set('added',new Date());
			$new_person->set('user',new oob_user(0)); // no user assigned at this point
			$new_person->set('project',$project);
			
			if ($new_person->store())
			{
				return $new_person;
			}
			
			return false;
		}
		
	}
	
	
	static public function exists($user)
	{
		global $ari, $project;
			
		if (!is_a($user,'oob_user'))
		{
			return false;
		}
		
		$string = $ari->db->qMagic($user->id());
		
		if (count($result = static::getList(false, false, false, false, false, false, false, "AND id_user = $string")) == 1)
		{
			return $result[0];
		}
		else
		{
			if ($result && is_a($project,'project_project'))
			{
				foreach ($result as $person)
				{
					if ($person->get('project')->id() == $project->id())
					{
						return $person;
					}
				}
			}
		}
		
		return false;
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
		global $ari;
		$ari->db->startTrans();
		
		// if we have ONLY ONE person linked to a user, we delete the user
		if ($this->get('user')->id() > 0 && project_person::getRelated($this->get('user'),true) == 1)
		{
			if (!$this->get('user')->delete())
			{
				$ari->db->failTrans();
			}
		}
		
		
		$filtros = array();
		$filtros[] = array("field"=>"status","type"=>"list","value"=>1);
		$filtros[] = array("field"=>"project","type"=>"list","value"=>$this->get('project')->id());
		$filtros[] = array("field"=>"asigned::id","type"=>"list","value"=>$this->id());
		if ($stories = project_story::getFilteredList(false, false, false, false, $filtros))
		{
			$person = new project_person(-1); //project_person::exists($this->get('project')->get('user'));
			
			foreach ($stories as $story)
			{
				$story->set('asigned', $person);
				if (!$story->store())
				{
					$ari->db->failTrans();
				}
			}
		
		}
		
		if(!parent::delete())
		{
			$ari->db->failTrans();
		}
		
		return $ari->db->completeTrans();
	}
	
	//@optimize: Magic to have all object synched with one user. (the user thinks he has only one profile, and we don't have to make complex magic tricks for projects)
	public function synchronize()
	{
		global $ari;
		
		// we search for all other people that are linked to the same oob_user
		
		// foreach person, we set the same values than the ones in this object 
	
	}
	
	// add synch code inside the store
	public function store()
	{
		
		$ct = new OOB_cleantext();
		$twitter_user = $ct->dropHTML($this->name());
		if ($twitter_profile = simplexml_load_string(@file_get_contents("http://twitter.com/users/show/{$twitter_user}.xml") ))
		{
			$this->set ('bio', $ct->dropHTML($twitter_profile->description));
			$this->set ('picture', $ct->dropHTML($twitter_profile->profile_image_url));
			$this->set ('url', $ct->dropHTML($twitter_profile->url));
		}
	
		
		if (parent::store())
		{
			$this->synchronize();
			return true;
		}
		
		return false;
	
	}
	
	

	public function name()
	{
		return $this->get('twitter_user');
	}
	
	public function picture ()
	{
		if ($this->get('picture') == '')
		{
			return '/images/avatar.gif';
		}
		else
		{
			return $this->get('picture');
		}
	}
	
	public function can_invite()
	{
		if ($this->get('user')->id() > 1)
		{
			return false;
		}
		else
		{
			return true;
		}
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
	
		// datos de la persona
		$plantilla->assign('name' ,$this->name());
		
		// datos del proyecto
		$plantilla->assign('project_name',$this->get('project')->name());
		$plantilla->assign('project_url',$this->get('project')->public_url());
		
		// datos del usuario
		$plantilla->assign('user',$user->get('uname'));
		$plantilla->assign('email',$user->get('email'));
		
		
		//////////// mail send
		require_once( $ari->get('enginedir') . DIRECTORY_SEPARATOR . 'librerias' . DIRECTORY_SEPARATOR . 'mimemessage' . DIRECTORY_SEPARATOR . 'smtp.php' );
		require_once( $ari->get('enginedir') . DIRECTORY_SEPARATOR . 'librerias' . DIRECTORY_SEPARATOR . 'mimemessage' . DIRECTORY_SEPARATOR . 'email_message.php' );
		require_once( $ari->get('enginedir') . DIRECTORY_SEPARATOR . 'librerias' . DIRECTORY_SEPARATOR . 'mimemessage' . DIRECTORY_SEPARATOR . 'smtp_message.php' );

		//estas dos referencias las agregue yo  por que me las pedia mi smtp
		require_once( $ari->get('enginedir') . DIRECTORY_SEPARATOR . 'librerias' . DIRECTORY_SEPARATOR . 'sasl' . DIRECTORY_SEPARATOR . 'sasl.php' );
		require_once( $ari->get('enginedir') . DIRECTORY_SEPARATOR . 'librerias' . DIRECTORY_SEPARATOR . 'sasl' . DIRECTORY_SEPARATOR . 'login_sasl_client.php' );
		require_once( $ari->get('enginedir') . DIRECTORY_SEPARATOR . 'librerias' . DIRECTORY_SEPARATOR . 'sasl' . DIRECTORY_SEPARATOR . 'cram_md5_sasl_client.php' );

		
		$email_message=new smtp_message_class;
		$email_message->localhost="";
		$email_message->smtp_host=$ari->config->get('delivery', 'main');
		$email_message->smtp_direct_delivery=0;
		$email_message->smtp_exclude_address="";
		$email_message->smtp_user=$ari->config->get('smtpuser', 'main');
		$email_message->smtp_realm="";
		$email_message->smtp_workstation="";
		$email_message->smtp_password=$ari->config->get('smtppass', 'main');
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