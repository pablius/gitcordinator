<?
/* Dashboard fields update 
- Here we update project name or sprint goal.
*/
$ari->popup=true;
/*
if (
	($project->get('user')->id() != $ari->user->id())
	||
	(!isset($_POST['field']))
	||
	(!isset($_POST['value']))
	)
{
	throw new OOB_exception('User not allowed to change goal or project name', "403", 'Not allowed',true);	
}
*/
$_POST['value'] = trim($_POST['value']);
$result = '';

switch ($_POST['field'])
{
	case 'editable_project_name':
	{
		$name = $project->name();
		$project->set('name',$_POST['value']);
		if ($project->store())
		{
			$result = $project->name();
		}
		else
		{
			$result = $name;
		}
		break;
	}
	
	case 'editable_goal':
	{
		$sprint = $project->current_sprint();
		$name = $sprint->name();
		$sprint->set('goal',$_POST['value']);
		if ($sprint->store())
		{
			$result = $sprint->name();
		}
		else
		{
			$result = $name;
		}
		break;
	}
	
	default:
	{
		throw new OOB_exception(var_export($_POST,true), "501", 'Data missmatch',true);		
		break;
	}


}

echo trim($result);
 
?>