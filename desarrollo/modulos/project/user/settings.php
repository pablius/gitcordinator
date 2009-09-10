<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
$ct = new OOB_cleantext();

$speeds = project_sprint_speed::getList();

$speed_array = array();
$s = 0;
foreach ($speeds as $speed)
{
	$speed_array[$s]['name'] = $speed->name();
	$speed_array[$s]['id'] = $speed->id();
	$s++;
}

if (($project->get('user')->id() != $ari->user->id()))
{
	throw new OOB_exception('', "403", 'Not allowed');	
}

// store
if (count ($_POST))
{
	$project->set ('name', $_POST['email']);
	$project->set ('repo_local', $_POST['repo_local']);
	$project->set ('sprint_speed', new project_sprint_speed($_POST['sprint_speed']));

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
$ari->t->assign("name", $ct->dropHTML($project->get('name')));
$ari->t->assign("repo_local", $ct->dropHTML($project->get('repo_local')));
$ari->t->assign("sprint_speed", $ct->dropHTML($project->get('sprint_speed')->id()));

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "settings.tpl");
 
?>