<?
/* Dashboard fields update 
- Here we update project name or sprint goal.
*/

if (
	($project->get('user')->id() != $ari->user->id())
	||
	(!isset($_GET['field']))
	||
	(!isset($_GET['value']))
	)
{
	throw new OOB_exception('', "403", 'Not allowed');	
}

$result = false;

switch ($_GET['field'])
{
	case 'project':
	{
		$project->set('name',$_GET['value']);
		if ($project->store())
		{
			$result = true;
		}
		break;
	}
	
	case 'goal':
	{
		$sprint = $project->current_sprint();
		$sprint->set('goal',$_GET['value']);
		if ($sprint->store())
		{
			$result = true;
		}
		break;
	}
	
	default:
	{
		throw new OOB_exception('', "404", 'Data missmatch');		
		break;
	}


}

// cambiar por js
if ($result)
{
	echo 'ok';
}
else
{
	echo 'fail';
}


 
?>