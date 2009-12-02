<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
$stories = array();

if (!isset($handle[2]) || !oob_validatetext::isClean($handle[2]))
{
	header( "Location: " . $ari->get('webaddress') . '/project/browse/sprints');
	exit;
}

$filtros = array();
$filtros[] = array("field"=>"status","type"=>"list","value"=>1);
$filtros[] = array("field"=>"project","type"=>"list","value"=>$project->id());
$filtros[] = array("field"=>"sprint::number","type"=>"numeric","value"=>$handle[2]);
$results = project_story::getFilteredList(false, false, false, false, $filtros);


if (!$results)
{
	header( "Location: " . $ari->get('webaddress') . '/project/browse/sprints');
	exit;
}
else
{
	$s = 0;
	foreach ($results as $story)
	{
		$stories[$s]['number'] = $story->number();
		$stories[$s]['text_class'] = $story->get('estimate')->get('css');
		$stories[$s]['name'] = $story->name();
		$stories[$s]['sprint'] = $story->get('sprint')->number();
		$stories[$s]['tags'] = $story->tags();
		$stories[$s]['asigned'] = $story->asigned()->name();
		$stories[$s]['state'] = $story->get('state')->name();
		$stories[$s]['state_class'] = $story->get('state')->class_name();
		$s++;
	}
	
	$sprint = $results[0]->get('sprint');
	$ari->t->assign('number',$sprint->number());
	$ari->t->assign('goal',$sprint->name());
	$ari->t->assign('stories',$stories);
	
}

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "browse_sprint.tpl");
 
?>