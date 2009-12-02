<?
global $ari;
$ari->t->caching = false;
$ari->popup = true;
$ari->t->force_compile = true;
$ct = new OOB_cleantext();

$result["success"] = false;
$result["data"] = array();
$result["errors"] = array();


$daily_scrum = project_daily::today($person, $project->current_sprint());


// store
if (count ($_POST))
{
	$daily_scrum->set ('today', $_POST['today']);
	$daily_scrum->set ('yesterday', $_POST['yesterday']);
	$daily_scrum->set ('blocks', $_POST['blocks']);
	
	
	if ($daily_scrum->store())
	{
		$result["success"] = true;
	}
	
	if ($errores = $daily_scrum->error()->getErrors())
	{
		$ari->t->assign("error", true);

		foreach ($errores as $error)
		{
			$ari->t->assign($error, true);
		}
	
	}
}
else
{
	$result["success"] = true;
}

// variables
$ari->t->assign("today", $ct->dropHTML($daily_scrum->get('today')));
$ari->t->assign("yesterday", $ct->dropHTML($daily_scrum->get('yesterday')));
$ari->t->assign("blocks", $ct->dropHTML($daily_scrum->get('blocks')));

$result["data"] = $ari->t->fetch($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "daily_scrum.tpl");		

// RESULTADO
$obj_comunication = new OOB_ext_comunication();
$obj_comunication->set_message("");
$obj_comunication->set_code("200");
$obj_comunication->set_data($result);
$obj_comunication->send(true,true);
?>