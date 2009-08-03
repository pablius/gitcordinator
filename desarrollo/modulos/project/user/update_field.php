<?
global $ari;

$allowed = array 
			(
				'sprint->goal' => array('project_sprint', 'goal'),
				'project->name' => array('project_project', 'name', ),
				'story->name' => array('project_story', 'name')
			);

if (
		isset ($_GET['object']) && isset($_GET['attribute']) 
		&& array_key_exists($_GET['object'] . '->' . $_GET['attribute'], $allowed) 
		&& isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0
		&& isset($_GET['value'])
	)
{
	$object  = $allowed[$_GET['object'] . '->' . $_GET['attribute']][0];
	$attribute = $allowed[$_GET['object'] . '->' . $_GET['attribute']][1];
	$id = $_GET['id'];
	$value = $_GET['value'];
	
	$object = new $object($id);
	
	// seguridad primitiva para que no cambien  lo que no les corresponde
	if (is_a($object, 'project_project'))
	{
		if ($object->get('user')->id() != $ari->user->id() || ($object->id() != $project->id()))
		{
			throw new OOB_exception('', "403", 'Not allowed');	
		}
		
	}
	else
	{	
		if ($object->get('project')->get('user')->id() != $ari->user->id() || ($object->get('project')->id() != $project->id()))
		{
			throw new OOB_exception('', "403", 'Not allowed');	
		}
	}
	
	$object->set($attribute, $value);
	
	if ($object->store())
	{
		echo true;
	}
	else
	{
		echo false;
	}
}
else
{
	throw new OOB_exception('', "404", 'Data missmatch');	
}

 
?>