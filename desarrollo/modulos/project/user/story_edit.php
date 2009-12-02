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
	project_notification::notify($person,'There was an error trying to edit this story, please try again later.',new project_notification_type(2));
}
else
{

$estimates = project_story_estimate::getList(false,false,'nombre');

$estimates_array = array();
$s = 0;
foreach ($estimates as $e)
{
	$estimates_array[$e->id()] = $e->name();
}

	// store
	if (count ($_POST) && isset($_POST['meta']) && isset($_POST['description']) && isset($_POST['demo']) && isset($_POST['estimate']))
	{
		$story->set('demo',$_POST['demo']);
		$story->set('description',$_POST['description']);
		$story->set('estimate',new project_story_estimate($_POST['estimate']));
		
		$tags = $story->set_from_meta($_POST['meta']);
		
		if ($story->store())
		{
			if ($old_tags = project_tag::getRelated($story))
			{
				foreach ($old_tags as $old)
				{
					$old->delete();
				}
			}
			
			if ($tags)
			{
				foreach ($tags as $new)
				{
					$new_tag = new project_tag();
					$new_tag->set ('tag',$new);
					$new_tag->set ('project',$project);
					$new_tag->set ('relacion',$story);
					$new_tag->store();
				}
			}
			$result["success"] = true;
		}
		else
		{
			if ($errors = $story->error()->getErrors())
			{
				foreach ($errors as $error)
				{
					$ari->t->assign($error,true);
				}
			}
		}
		$ari->t->assign('meta',$ct->dropHTML($_POST['meta']));
	}
	else
	{
		$result["success"] = true;
		$ari->t->assign('meta',$ct->dropHTML($story->meta()));
	}
	
	$ari->t->assign('name',$ct->dropHTML($story->name()));
	$ari->t->assign('number',$ct->dropHTML($story->number()));
	$ari->t->assign('asigned',$ct->dropHTML($story->get('asigned')->name()));
	$ari->t->assign('estimates_array',$estimates_array);
	$ari->t->assign('estimate',$ct->dropHTML($story->get('estimate')->id()));
	$ari->t->assign('description',$ct->dropHTML($story->get('description')));
	$ari->t->assign('demo',$ct->dropHTML($story->get('demo')));
	
	$tags_array = $story->tags();
	$ari->t->assign('tags',$tags_array);
	
	
	$result["data"] = $ari->t->fetch($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "story_edit.tpl");		
	
}

// RESULTADO
$obj_comunication = new OOB_ext_comunication();
$obj_comunication->set_message("");
$obj_comunication->set_code("200");
$obj_comunication->set_data($result);
$obj_comunication->send(true,true);

?>
 