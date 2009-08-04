<?
global $ari;
$ari->t->caching = false;

// process new stories creation


$ari->t->assign('sprint_number',$project->current_sprint()->number());
$ari->t->assign('sprint_goal',$project->current_sprint()->name());

// get stories for unplaned
$unplaned_items = array();
$u = 0;
if ($unplaned = project_story::getRelated($project->unplaned()))
{
	foreach ($unplaned as $u_story)
	{
		$unplaned_items[$u]['id'] = $u_story->id();
		$unplaned_items[$u]['name'] = $u_story->name();
		$unplaned_items[$u]['asigned'] = $u_story->asigned()->name();
		$unplaned_items[$u]['tags'] = $u_story->tags();
		$u++;
	}
}

$ari->t->assign('unplaned',$unplaned_items);

// get stories for pb
$pb_items = array();
$p = 0;
if ($pb = project_story::getRelated($project->product_backlog()))
{
	foreach ($pb as $story)
	{
		$pb_items[$p]['id'] = $story->id();
		$pb_items[$p]['name'] = $story->name();
		$pb_items[$p]['asigned'] = $story->asigned()->name();
		$pb_items[$p]['tags'] = $story->tags();
		$p++;
	}
}
$ari->t->assign('product_backlog',$pb_items);


// get stories for current_sprint
$current_items = array();
$c = 0;
if ($cb = project_story::getRelated($project->current_sprint()))
{
	foreach ($cb as $story)
	{
		$current_items[$c]['id'] = $story->id();
		$current_items[$c]['name'] = $story->name();
		$current_items[$c]['asigned'] = $story->asigned()->name();
		$current_items[$c]['tags'] = $story->tags();
		$c++;
	}
}
$ari->t->assign('current_sprint',$current_items);


$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "dashboard.tpl");
 
?>