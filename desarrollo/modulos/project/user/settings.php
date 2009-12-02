<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
$ct = new OOB_cleantext();

$speeds = project_sprint_speed::getList(false,false,'nombre');

$speed_array = array();
$s = 0;
foreach ($speeds as $speed)
{
	$speed_array[$speed->id()] = $speed->name();
}

/*if (($project->get('user')->id() != $ari->user->id()))
{
	throw new OOB_exception('', "403", 'Not allowed');	
}*/

// store
if (count ($_POST))
{
	if (isset ($_POST['name']))
	{
		$project->set ('name', $_POST['name']);
	}
	
	if (!isset ($_POST['repo_local']) || !in_array($_POST['repo_local'],array(0,1)))
	{
		$_POST['repo_local'] = 0;
	}
	
	$project->set ('repo_local', $_POST['repo_local']);
	
	if (!isset ($_POST['sprint_speed']) || !array_key_exists($_POST['sprint_speed'],$speed_array))
	{
		$_POST['sprint_speed'] = 1;
	}
	
	
	$project->set ('sprint_speed', new project_sprint_speed($_POST['sprint_speed']));
	
	if($project->store())
	{
		project_notification::notify($person, 'Project settings saved.',new project_notification_type(1));
		header( "Location: " . $ari->get('webaddress') . '/project/dashboard');
		exit;
	}

	if ($errores = $project->error()->getErrors())
	{
		$ari->t->assign("error", true);

		foreach ($errores as $error)
		{
			$ari->t->assign($error, true);
		}
	}
}

// variables
$ari->t->assign("speed_array", $speed_array);
$ari->t->assign("name", $ct->dropHTML($project->get('name')));
$ari->t->assign("repo_local", $ct->dropHTML($project->get('repo_local')));
$ari->t->assign("sprint_speed", $ct->dropHTML($project->get('sprint_speed')->id()));

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "settings.tpl");
 
?>