<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
// process new stories creation


$ari->t->assign('sprint_number',$project->current_sprint()->number());
$ari->t->assign('sprint_goal',$project->current_sprint()->name());
$ari->t->assign('sprint_start_date',$project->current_sprint()->get('start')->format("%b %e"));
$ari->t->assign('sprint_end_date',$project->current_sprint()->get('finish')->format("%b %e"));

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

$ari->t->assign('unplaned',$unplaned_items);
$ari->t->assign('unplaned_total',$project->unplaned()->total_estimate());

// get stories for pb
$pb_items = array();
$p = 0;
if ($pb = project_story::getRelated($project->product_backlog(),false,'relevance'))
{
	foreach ($pb as $story)
	{
		$pb_items[$p]['number'] = $story->number();
		$pb_items[$p]['relevance'] = $story->get('relevance');
		$pb_items[$p]['text_class'] = $story->get('estimate')->get('css');
		$pb_items[$p]['name'] = $story->name();
		$pb_items[$p]['asigned'] = $story->asigned()->name();
		$pb_items[$p]['tags'] = $story->tags();
		$p++;
	}
}
$ari->t->assign('product_backlog',$pb_items);
$ari->t->assign('product_backlog_total',$project->product_backlog()->total_estimate());

// get stories for current_sprint
$current_items = array();
$c = 0;
if ($cb = project_story::getRelated($project->current_sprint(),false,'relevance'))
{
	foreach ($cb as $story)
	{
		$current_items[$c]['number'] = $story->number();
		$current_items[$c]['relevance'] = $story->get('relevance');
		$current_items[$c]['text_class'] = $story->get('estimate')->get('css');
		$current_items[$c]['name'] = $story->name();
		$current_items[$c]['asigned'] = $story->asigned()->name();
		$current_items[$c]['tags'] = $story->tags();
		$c++;
	}
}
$ari->t->assign('current_sprint',$current_items);
$ari->t->assign('current_sprint_total',$project->current_sprint()->total_estimate());

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "dashboard.tpl");
 
?>