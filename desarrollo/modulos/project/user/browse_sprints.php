<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
$sprints = array();

$filtros = array();
$filtros[] = array("field"=>"status","type"=>"list","value"=>1);
$filtros[] = array("field"=>"project","type"=>"list","value"=>$project->id());
$filtros[] = array("field"=>"number","type"=>"numeric","value"=>0, 'comparison' => 'neq');
$results = project_sprint::getFilteredList(false, false, false, DESC, $filtros);
	
$s = 0;
foreach ($results as $sprint)
{
	$sprints[$s]['goal'] = $sprint->name();
	$sprints[$s]['number'] = $sprint->number();
	$sprints[$s]['total_estimate'] = $sprint->total_estimate();
	$sprints[$s]['result'] = $sprint->get('eval_meeting_result');
	$sprints[$s]['started'] = $sprint->get('start')->format('%D');
	$sprints[$s]['finished'] = $sprint->get('finish')->format('%D');
	$sprints[$s]['finished_string'] = (strtotime($sprints[$s]['finished']) > strtotime(date('M j, Y')))?'Estimated finish on':'Finished';
	//$sprints[$s]['number'] = $sprint->number();

	
	
	$s++;
}


$ari->t->assign('sprints',$sprints);

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "browse_sprints.tpl");
 
?>