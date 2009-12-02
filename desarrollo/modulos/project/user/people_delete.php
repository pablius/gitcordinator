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
	if (isset($_POST['name']) && $_POST['name'] != '')
	{
			
		if (!$person_delete = project_person::from_name($_POST['name'],$project))
		{
			throw new OOB_exception('', "403", 'Data missmatch.');
		}
		else
		{
			
			if ($person_delete->delete())
			{
				$result["data"] = $person_delete->name() . ' was deleted.';
				project_notification::notify($person,'@'.$person_delete->name() . ' was deleted.',new project_notification_type(1));
				$result["success"] = true;
			}
			else
			{
				$invite_fail[] = $person_delete->name();
				$result["data"] = '@'. $person_delete->name() . ' couldn\'t be deleted. Are you trying to delete yourself or the Scrum Master?';
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