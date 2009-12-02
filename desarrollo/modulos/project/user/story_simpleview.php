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
	project_notification::notify($person,'There was an error trying to load a story, please try again later.',new project_notification_type(2));
}
else
{
	
	$result["success"] = true;
	$ari->t->assign('name',$ct->dropHTML($story->name()));
	$ari->t->assign('number',$ct->dropHTML($story->number()));
	$ari->t->assign('asigned',$ct->dropHTML($story->get('asigned')->name()));
	$ari->t->assign('text_class',$ct->dropHTML($story->get('estimate')->get('css')));
	
	$ari->t->assign('estimate',$ct->dropHTML($story->get('estimate')->id()));
	$ari->t->assign('description',$ct->dropHTML($story->get('description')));
	$ari->t->assign('demo',$ct->dropHTML($story->get('demo')));
	
	$tags_array = $story->tags();
	$ari->t->assign('tags',$tags_array);
	
	$ari->t->assign('meta',$ct->dropHTML($story->meta()));
	
	if (in_array($story->get('sprint')->get('kind')->id(),array(2,3)))
	{
		$result["data"] = $ari->t->fetch($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "story_simpleview_mini.tpl");		
	}
	else
	{
		$result["data"] = $ari->t->fetch($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "story_simpleview.tpl");		
	}	
}

// RESULTADO
$obj_comunication = new OOB_ext_comunication();
$obj_comunication->set_message("");
$obj_comunication->set_code("200");
$obj_comunication->set_data($result);
$obj_comunication->send(true,true);

?>
 