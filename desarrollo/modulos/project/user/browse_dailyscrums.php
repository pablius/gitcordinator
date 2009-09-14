<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;
$ds_result = array();

$filtros = array();

if (isset($_GET['sprint']) && oobNumeric::isValid($_GET['sprint']))
{
	$filtros[] = array("field"=>"sprint:number","type"=>"numeric","value"=>$_GET['sprint']);
}

if (isset($_GET['person']))
{
	$filtros[] = array("field"=>"person:twitter_user","type"=>"string","value"=>$_GET['person']);
}


$filtros[] = array("field"=>"status","type"=>"list","value"=>1);
$filtros[] = array("field"=>"sprint::project","type"=>"list","value"=>$project->id());

$results = project_daily::getFilteredList(false, false, false, DESC, $filtros);


$s = 0;
foreach ($results as $ds)
{
	$ds_result[$s]['person'] = $ds->get('person')->name();
	$ds_result[$s]['sprint'] = $ds->get('sprint')->number();
	$ds_result[$s]['yesterday'] = project_tag::link_tags(project_person::link_people($ds->get('yesterday'),$project),$project);
	$ds_result[$s]['today'] = project_tag::link_tags(project_person::link_people($ds->get('today'),$project),$project);
	$ds_result[$s]['blocks'] = project_tag::link_tags(project_person::link_people($ds->get('blocks'),$project),$project);
	$ds_result[$s]['date'] = $ds->get('date')->format('%D');
	$s++;
}


$ari->t->assign('ds_result',$ds_result);

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "browse_dailyscrums.tpl");
 
?>