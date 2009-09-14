<?
$ari->t->catching =0;
$ari->t->force_compile =true;

if (!isset($handle[2]) || !oob_numeric::isValid($handle[2]))
{
	throw new OOB_exception('', "501", "URL is incomplete");
}

if (!$story = project_story::number_constructor($handle[2],$project))
{
	throw new OOB_exception('', "404", "Story not found");
}

$ari->t->assign('name',$story->name());
$ari->t->assign('number',$story->number());
$ari->t->assign('asigned',$story->get('asigned')->name());
$ari->t->assign('date',$story->get('date')->format('%D'));
$ari->t->assign('state',$story->get('state')->name());
$ari->t->assign('estimate',$story->get('estimate')->name());
$ari->t->assign('demo',$story->get('demo'));
$ari->t->assign('description',$story->get('description'));


if ($tags = project_tag::getRelated($story))
{
	$tags_array = array();
	$t = 0;
	foreach ($tags as $tag)
	{
		$tags_array[$t]['name'] = $tag->name();
		$t++;
	}
	$ari->t->assign('tags',$tags_array);
}

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "story_view.tpl");
 
?>