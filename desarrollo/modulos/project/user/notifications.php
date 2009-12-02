<?php
$ari->popup = true;
$result["data"] = array();
$result["success"] = true;



//project_notification::notify($person,'NOTIFICATION TEST',new project_notification_type(1),false);

// delete notifications
if (count ($_POST) && isset($_POST['clear']) && $_POST['clear'] == true)
{
	$result["success"] = project_notification::clear($person);
}

if ($notifications = project_notification::getRelated($person))
{
	foreach ($notifications as $notification)
	{
		$result["data"]['css'] = $notification->get('type')->get('style');
		$result["data"]['message'] = $notification->get('text');
		
		if ($notification->get('selfclear'))
		{
			$notification->delete();
		}
	}
}
else
{	
	$result["success"] = false;
}

// RESULTADO
$obj_comunication = new OOB_ext_comunication();
$obj_comunication->set_message("");
$obj_comunication->set_code("200");
$obj_comunication->set_data($result);
$obj_comunication->send(true,true);	
?>