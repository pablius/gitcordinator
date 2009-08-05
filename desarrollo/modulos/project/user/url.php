<?


global $ari;
global $project;

$handle = $ari->url->getVars();
// perspective for logued in users
$ari->perspective = new oob_perspective ('pp');

var_dump ($handle);

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
else
{
	echo 'URL not found';
	//throw new OOB_exception('', "404", 'URL not found');	
}
?>