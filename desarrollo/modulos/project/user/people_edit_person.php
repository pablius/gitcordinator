<?
global $ari;
$ari->popup = true;
$ari->t->caching = false;
$ari->t->force_compile = true;
$ct = new OOB_cleantext();

$result["success"] = false;
$result["data"] = array();
$result["errors"] = array();

if (!isset($handle[1]) || !oob_validatetext::isClean($handle[1]) || !$invite_person = project_person::from_name($handle[1],$project))
{
	project_notification::notify($person,'There was an error trying to edit this team member, please try again later.',new project_notification_type(2));
}
else
{
	// store
	if (count ($_POST))
	{
		$invite_person->set ('twitter_user', $_POST['name']);
		$invite_user = $invite_person->get('user');
		
		$invite_user->set ('uname', $_POST['email']);
		$invite_user->set('email',$_POST['email']);
		
		if (isset($_POST['password']) && isset($_POST['repeat']) && $_POST['password'] != '' && $_POST['repeat'] !=='')
		{	
			if($_POST['password'] === $_POST['repeat'])
			{
				$invite_user->set('password',$_POST['password']);
			}
			else
			{
				$invite_user->error()->addError ( "NO_CONCUERDAN");
			}
		}elseif (
				isset($_POST['password']) && isset($_POST['repeat']) &&
				(($_POST['password'] == '' && $_POST['repeat'] !=='') || ($_POST['password'] !== '' && $_POST['repeat'] ==''))
				)
		{
			$invite_user->error()->addError ( "NO_CONCUERDAN");
		}
		
		$ari->db->startTrans();
		
		if (!$invite_user->store())
		{
			$ari->db->FailTrans();
		}

		
		if (!$invite_person->store())
		{
			$ari->db->FailTrans();
		}
		
			
		if($ari->db->completeTrans())
		{
			project_notification::notify($person,'Person has been updated.',new project_notification_type(1));
			$result["success"] = true;
		}

		$errores = array();
		$errores = array_merge($errores,$invite_person->error()->getErrors());
		$errores = array_merge($errores,$invite_user->error()->getErrors());
		
		if (count($errores))
		{
			$result["errors"] = $errores;
		}
				
	}
	else
	{
		$ari->t->assign("name", $ct->dropHTML($invite_person->name()));
		$ari->t->assign("email", $ct->dropHTML($invite_person->get('user')->get('email')));

		$result["success"] = true;
		$result["data"] = $ari->t->fetch($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "people_edit_person.tpl");		
	}
}

// RESULTADO
$obj_comunication = new OOB_ext_comunication();
$obj_comunication->set_message("");
$obj_comunication->set_code("200");
$obj_comunication->set_data($result);
$obj_comunication->send(true,true);

?>
 