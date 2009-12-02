<?
/* Create a story from a string
*/
$ari->popup = true;

$plantilla = $ari->newTemplate();
$plantilla->caching = 0;

$result["success"] = false;
$result["data"] = array();



if (isset($_POST['story']))
{
	$result["success"] = project_story::new_from_string($_POST['story'],$project->unplaned());
	
	// get stories for unplaned
	$unplaned_items = array();
	$u = 0;
	if ($unplaned = project_story::getRelated($project->unplaned(),false,'relevance'))
	{
		foreach ($unplaned as $u_story)
		{
			$unplaned_items[$u]['number'] = $u_story->number();
			$unplaned_items[$u]['relevance'] = $u_story->get('relevance');
			$unplaned_items[$u]['text_class'] = $u_story->get('estimate')->get('css');
			$unplaned_items[$u]['name'] = $u_story->name();
			$unplaned_items[$u]['asigned'] = $u_story->asigned()->name();
			$unplaned_items[$u]['tags'] = $u_story->tags();	
			$u++;
		}
	}

	$plantilla->assign('unplaned',$unplaned_items);
	
	$result["data"]['unplanned'] = $plantilla->fetch($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "story_shortnew.tpl");
	$result["data"]['unplanned_count'] = $project->unplaned()->total_estimate();
}

// RESULTADO
$obj_comunication = new OOB_ext_comunication();
$obj_comunication->set_message("");
$obj_comunication->set_code("200");
$obj_comunication->set_data($result);
$obj_comunication->send(true,true);

 
?>