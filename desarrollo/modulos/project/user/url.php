<?


global $ari;
global $project;

$handle = $ari->url->getVars();
// perspective for logued in users
$ari->perspective = new oob_perspective ('pp');

var_dump ($handle);

$active_dashboard=false;
$active_browse=false;
$active_metrics=false;

if (isset($handle[0]))
{
	switch ($handle[0])
	{
		case 'dashboard':
		{
			$active_dashboard=true;
			break;
		}
		
		case 'browse':
		{
			$active_browse=true;
			break;
		}
		
		case 'metrics':
		{
			$active_metrics=true;
			break;
		}
	}
}

$ari->perspective->template->assign('active_dashboard',$active_dashboard);
$ari->perspective->template->assign('active_browse',$active_browse);
$ari->perspective->template->assign('active_metrics',$active_metrics);

/// here is the code to detect the project that goes with the URL 
$project = project_project::url_detect($handle);
$ari->description = $project->name();
$ari->set_title($project->name());

// no allowance if you have no user (placed here to update webaddress)
seguridad::RequireLogin();


if (isset ($handle[1]) && file_exists ($ari->module->userdir() . DIRECTORY_SEPARATOR  . $handle[0] . "_" .$handle[1] . ".php"))
{
	include ($ari->module->userdir() . DIRECTORY_SEPARATOR  . $handle[0] . "_" . $handle[1] . ".php");
}
elseif (file_exists ($ari->module->userdir() . DIRECTORY_SEPARATOR  . $handle[0] . ".php"))
{
	include ($ari->module->userdir() . DIRECTORY_SEPARATOR  . $handle[0] . ".php");
}
else
{
	echo 'URL not found';
	//throw new OOB_exception('', "404", 'URL not found');	
}
?>