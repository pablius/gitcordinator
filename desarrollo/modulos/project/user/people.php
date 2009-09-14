<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
$people_array = array();
$fail = array();
$success = array();

$invite_success = array();
$invite_fail = array();

if (count($_POST))
{
	// add people to the project
	if (isset($_POST['add_people']) && $_POST['add_people'] != '')
	{
		$new_people = str_replace(',',' ',explode(' ',$_POST['add_people']));
		if (count($new_people))
		{
			foreach ($new_people as $new_person)
			{
				if (substr($new_person,0,1) == '@')
				{
					$new_person = substr($new_person,1,strlen($new_person));
				}
				else
				{
					$fail[] = $new_person;
					continue;
				}
				
				if (!project_person::create_new_person($new_person,$project))
				{
					$fail[] = $new_person;
				}
				else
				{
					$success[] = $new_person;
				}
				
			}
			
			header( "Location: " . $ari->get('webaddress') . '/project/people');
			exit;
			
		}
	}
	
	// process mail invite sending
	if (isset($_POST['email']) && $_POST['email'] != '')
	{
		if (!$person = project_person::from_name($_POST['name'],$project))
		{
			throw new OOB_exception('', "403", 'Data missmatch.');
		}
		else
		{
			$ari->db->startTrans();
			$user = new oob_user();
			$user->set('email',$_POST['email']);
			$user->set('uname',$_POST['email']);
			$user->set('password',$person->name());
			$user->set('status',1);
			
			if (!$user->store()) /// we are creating the user here!
			{
				$ari->db->failTrans();
			}
			else
			{		
				$user->linkStandardGroup();
				$person->set('user',$user);
				
				if (!$person->store())
				{
					$ari->db->failTrans();
				}
			}
			
			if ($ari->db->completeTrans())
			{
				$person->send_mail_invite();
				$invite_success[]=$person->name();
			}
			else
			{
				$invite_fail[]=$person->name();
			}
		}
	}
}


if ($people = project_person::getRelated($project))
{
	$p=0;
	foreach ($people as $person)
	{
		$people_array[$p]['name'] = $person->name();
		$people_array[$p]['picture'] = $person->picture();
		$people_array[$p]['bio'] = $person->get('bio');
		$people_array[$p]['url'] = $person->get('url');
		$people_array[$p]['invite'] = $person->can_invite();
		if (in_array($person->name(),$invite_fail))
		{
			$people_array[$p]['invite_fail'] = true;
		}
		else
		{
			$people_array[$p]['invite_fail'] = false;
		}
		$p++;
	}
}

$ari->t->assign('people',$people_array);
$ari->t->assign('people_tags',project_person::project_tag_cloud($project));

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "people.tpl");
 
?>