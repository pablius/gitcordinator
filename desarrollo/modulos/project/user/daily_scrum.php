<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
$ct = new OOB_cleantext();

$daily_scrum = project_daily::today($person, $project->current_sprint());


// store
if (count ($_POST))
{
	$daily_scrum->set ('today', $_POST['today']);
	$daily_scrum->set ('yesterday', $_POST['yesterday']);
	$daily_scrum->set ('blocks', $_POST['blocks']);
	
	
	if ($daily_scrum->store())
	{
		header( "Location: " . $ari->get('webaddress') . '/project/dashboard');
		exit;
	}
	
	if ($errores = $daily_scrum->error()->getErrors())
	{
		$ari->t->assign("error", true);

		foreach ($errores as $error)
		{
			$ari->t->assign($error, true);
		}
		
		var_dump ($errores);
	}
}

// variables
$ari->t->assign("today", $ct->dropHTML($daily_scrum->get('today')));
$ari->t->assign("yesterday", $ct->dropHTML($daily_scrum->get('yesterday')));
$ari->t->assign("blocks", $ct->dropHTML($daily_scrum->get('blocks')));


$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "daily_scrum.tpl");
 
?>