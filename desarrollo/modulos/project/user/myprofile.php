<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
$ct = new OOB_cleantext();


// store
if (count ($_POST))
{
	$person->set ('twitter_user', $_POST['name']);
	$ari->user->set ('uname', $_POST['email']);
	$ari->user->set('email',$_POST['email']);
	
	if (isset($_POST['password']) && isset($_POST['repeat']) && $_POST['password'] != '' && $_POST['repeat'] !=='')
	{	
		if($_POST['password'] === $_POST['repeat'])
		{
			$ari->user->set('password',$_POST['password']);
		}
		else
		{
			$ari->user->error()->addError ( "NO_CONCUERDAN");
		}
	}elseif (
			isset($_POST['password']) && isset($_POST['repeat']) &&
			(($_POST['password'] == '' && $_POST['repeat'] !=='') || ($_POST['password'] !== '' && $_POST['repeat'] ==''))
			)
	{
		$ari->user->error()->addError ( "NO_CONCUERDAN");
	}
	
	$twitter_user = $ct->dropHTML($person->name());
	if ($twitter_profile = simplexml_load_string(@file_get_contents("http://twitter.com/users/show/{$twitter_user}.xml") ))
	{
		$person->set ('bio', $ct->dropHTML($twitter_profile->description));
		$person->set ('picture', $ct->dropHTML($twitter_profile->profile_image_url));
		$person->set ('url', $ct->dropHTML($twitter_profile->url));
	}
	
	

	
	$ari->db->startTrans();
	
	if (!$ari->user->store())
	{
		$ari->db->FailTrans();
	}

	
	if (!$person->store())
	{
		$ari->db->FailTrans();
	}
	
		
	if($ari->db->completeTrans())
	{
		header( "Location: " . $ari->get('webaddress') . '/project/dashboard');
		exit;
	}

	$errores = array();
	$errores = array_merge($errores,$person->error()->getErrors());
	$errores = array_merge($errores,$ari->user->error()->getErrors());
	
	var_dump ($errores);
	
	if (count($errores))
	{
		$ari->t->assign("error", true);

		foreach ($errores as $error)
		{
			$ari->t->assign($error, true);
		}
	}
}

// variables
$ari->t->assign("name", $ct->dropHTML($person->name()));
$ari->t->assign("email", $ct->dropHTML($person->get('user')->get('email')));

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "myprofile.tpl");
 
?>