<?
/* Create a story from a string
*/

if (
	(!isset($_POST['story']))
	)
{
	throw new OOB_exception('', "404", 'Data missmatch');		
}



$result = project_story::new_from_string($_POST['story'],$project->unplaned());

// cambiar por js
if ($result)
{
	header( "Location: " . $ari->get('webaddress') . '/project/dashboard');
	exit;
}
else
{
	echo 'fail';
}


 
?>