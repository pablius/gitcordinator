<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
$ari->popup = true;

$result["success"] = false;
$result["data"] = array();
$result["errors"] = array();

if (count($_POST))
{

	// process mail invite sending
	if (isset($_POST['email']) && $_POST['email'] != '')
	{
			
		if (!$invite_person = project_person::from_name($_POST['name'],$project))
		{
			throw new OOB_exception('', "403", 'Data missmatch.');
		}
		else
		{
			$ari->db->startTrans();
			if ($invite_person->get('user')->id() == -1)
			{
				$user = new oob_user();
				$new_user = true;
			}
			else
			{
				$user = $invite_person->get('user');
				$new_user = false;
			}
			
			$user->set('email',$_POST['email']);
			$user->set('uname',$_POST['email']);
			$user->set('password',$invite_person->name());
			$user->set('status',1);
			
			if (!$user->store()) /// we are creating the user here!
			{
				$ari->db->failTrans();
				$e = $user->error()->getErrors();
				///$user->error()->addError(var_export($e,true),true); -> debug line
			}
			else
			{		
				if ($new_user)
				{
					$user->linkStandardGroup();
					$invite_person->set('user',$user);
				}	
				
				if (!$invite_person->store())
				{
					$ari->db->failTrans();
				}
			}
			
			if ($ari->db->completeTrans())
			{
				$invite_person->send_mail_invite();
				$result["data"] = '@'.$invite_person->name() . ' was invited to join the project.';
				project_notification::notify($person,'@'.$invite_person->name() . ' was invited to join the project.',new project_notification_type(1));
				$result["success"] = true;
			}
			else
			{
				$invite_fail[] = $invite_person->name();
				$result["data"] = '@'.$invite_person->name() . ' couldn\'t be invited. Please check the e-mail address and try again.';
			}
			
			
		}
	}
}

// RESULTADO
$obj_comunication = new OOB_ext_comunication();
$obj_comunication->set_message("");
$obj_comunication->set_code("200");
$obj_comunication->set_data($result);
$obj_comunication->send(true,true);
 
?>