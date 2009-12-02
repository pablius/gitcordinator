<?
$ct = new OOB_cleantext();
$ari->t->catching = false;
$ari->t->force_compile = true;

// we send them back to setup 1
if (!isset($_POST['name']))
{
	header( "Location: " . $ari->get('webaddress') . '/project/setup/1');
	exit;
}

// availability name check
if (isset($_POST['availability']))
{
	$ari->popup = true;
	$result["data"] = array();
	$result["success"] = project_project::is_available($_POST['name']);
	
	// RESULTADO
	$obj_comunication = new OOB_ext_comunication();
	$obj_comunication->set_message("");
	$obj_comunication->set_code("200");
	$obj_comunication->set_data($result);

	$obj_comunication->send(true,true);	
	exit;
}

$ari->db->startTrans();
// we try to create the project with the given name, if we fail, we send the user back to step 1 (it should never happen, because we are validating it with js in the previous screen
$new_project = new project_project();
$new_project->set('name','Edit your project name');
$new_project->set('sprint_speed',new project_sprint_speed(1));
// $new_project->set('importance_rate',new project_importance_rate(1)); /// lo sacamos.
$new_project->set('url_repo',$_POST['name']);
$new_project->set('repo_local',true);
$new_project->set('repo',new project_repository_type(1));
$new_project->set('user',$ari->user);


if (!$new_project->store())
{
	header( "Location: " . $ari->get('webaddress') . '/project/setup/1');
	exit;
}
else
{
	// sprint
	$today = new Date(date('Y-m-d'));
	$finish =  new Date(date('Y-m-d',  strtotime("+".$new_project->get('sprint_speed')->get('days')." days")));
	$new_sprint = new project_sprint();
	$new_sprint->set('project',$new_project);
	$new_sprint->set('start',$today);
	$new_sprint->set('finish',$finish);
	$new_sprint->set('goal','Set a goal for this sprint');
	$new_sprint->set('kind',new project_sprint_kind(1));
	$new_sprint->set('number',1);
	if(!$new_sprint->store())
	{
		$ari->db->FailTrans();
	}
	
	// backlog
	$product_backlog = new project_sprint();
	$product_backlog->set('project',$new_project);
	$product_backlog->set('start',$today);
	$product_backlog->set('finish',$finish);
	$product_backlog->set('goal','Product BackLog');
	$product_backlog->set('kind',new project_sprint_kind(2));
	$product_backlog->set('number',0);
	if(!$product_backlog->store())
	{
		$ari->db->FailTrans();
	}
	
	//undefined
	$undefined = new project_sprint();
	$undefined->set('project',$new_project);
	$undefined->set('start',$today);
	$undefined->set('finish',$finish);
	$undefined->set('goal','Undefined');
	$undefined->set('kind',new project_sprint_kind(3));
	$undefined->set('number',0);
	if(!$undefined->store())
	{
		$ari->db->FailTrans();
	}
	
	// create person for this user.
	$new_person = new project_person();
	
	// we'll set twitter user name as a the user part of his email address
	$arroba = strpos($ari->user->get('uname'),'@');
	$twitter_user = substr($ari->user->get('uname'),0,$arroba);
	
	$new_person->set('twitter_user',$twitter_user);
	$new_person->set('added',new Date());
	$new_person->set('user',$ari->user);
	$new_person->set('project',$new_project);
	
	if(!$new_person->store())
	{
		$ari->db->FailTrans();
	}
	
	if (!$ari->db->completeTrans())
	{
		throw new OOB_exception('PROJECT SCREWED', "501", 'It seems like we screwed up with you. Your project was created, but something else failed. Our tech team is being notified as you read.', true);
	}
	
}



$ari->t->assign('url', $ct->dropHTML($_POST['name']) . '.clarisapp.com');
$ari->t->assign('user', $ct->dropHTML($ari->user->get('uname')));
$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "setup_2.tpl");
 
?>