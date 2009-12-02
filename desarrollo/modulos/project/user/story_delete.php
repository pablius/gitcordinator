<?
global $ari;
$ari->popup = true;
$ari->t->caching = false;
$ari->t->force_compile = true;
$ct = new OOB_cleantext();

$result["success"] = false;
$result["data"] = array();
$result["errors"] = array();

if (!isset($handle[2]) || !oob_validatetext::isClean($handle[2]) || !$story = project_story::number_constructor($handle[2],$project))
{
	project_notification::notify($person,'There was an error trying to delete a story, please try again later.',new project_notification_type(2));
}
else
{
	// @optimize only assigned or creator should be allowed to delete.

	if ($story->delete())
	{
		$result["success"] = true;
	}
	
	if (isset($_POST['parent']) && in_array($_POST['parent'],array('current_sprint','product_backlog','unplaned_stories')))
	{
		switch ($_POST['parent'])
		{
			case "current_sprint":
			{
				$result["data"]['count'] = $project->current_sprint()->total_estimate();
				$result["data"]['counter'] = '#current_sprint_count';
				break;
			}
			
			case "product_backlog":
			{
				$result["data"]['count'] = $project->product_backlog()->total_estimate();
				$result["data"]['counter'] = '#pb_count';
				break;
			}
			
			case "unplaned_stories":
			{
				$result["data"]['count'] = $project->unplaned()->total_estimate();
				$result["data"]['counter'] = '#unplaned_count';
				break;
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
 