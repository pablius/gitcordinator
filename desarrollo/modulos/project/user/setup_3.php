<?
if (count($_POST))
{
	// viene la historia para grabar, la grabamos, y redirigimos al dashboard de una vez!
	
	
	if (project_story::new_from_string($_POST['new_story'],$project->this_sprint()))
	{
		// redirigimos al dashboard		
		header( "Location: " . $ari->get('webaddress') . '/project/dashboard');
		exit;
	}
	else
	{
		$ari->t->assign('error',true);
	}
	
}

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "setup_3.tpl");
 
?>