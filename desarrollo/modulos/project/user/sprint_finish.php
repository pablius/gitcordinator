﻿<?

/* Sprint Finish logic
----------------------
- We close the actual sprint
- We create a new one
- We move unfinished stories to the new story
*/

global $ari;
$ari->popup = true;

$result["success"] = false;
$result["data"] = array();
$result["errors"] = array();


if ($project->get('user')->id() != $ari->user->id())
{
	//throw new OOB_exception('', "403", 'Not allowed');	
}
else
{
	$current_sprint = $project->current_sprint();
	$today = new Date(date('Y-m-d'));
	$finish =  new Date(date('Y-m-d',  strtotime("+".$project->get('sprint_speed')->get('days')." days")));

	$ari->db->startTrans();

	$new_sprint = new project_sprint();
	$new_sprint->set('project',$project);
	$new_sprint->set('start',$today);
	$new_sprint->set('finish',$finish);
	$new_sprint->set('goal','Set a goal for this sprint');
	$new_sprint->set('kind',new project_sprint_kind(1));
	$new_sprint->set('number',$current_sprint->get('number') + 1); // se supone que lo hace sola.

	if($new_sprint->store())
	{
		$current_sprint->set('finish',$today);
		if(!$current_sprint->store())
		{
			$ari->db->FailTrans();
		}
		
		if ($sprint_stories = project_story::getRelated($current_sprint))
		{
			
			foreach ($sprint_stories  as $story)
			{
				if ($story->get('state')->id()  != 4)
				{
					$story->set('sprint',$new_sprint);
					if(!$story->store())
					{
						$ari->db->FailTrans();
					}
				}
			
			}
			
		}
		
	}
	else
	{
		$ari->db->FailTrans();
	}
	
	if ($ari->db->completeTrans())
	{
		$result["success"] = true;
	}
}

// RESULTADO
$obj_comunication = new OOB_ext_comunication();
$obj_comunication->set_message("");
$obj_comunication->set_code("200");
$obj_comunication->set_data($result);
$obj_comunication->send(true,true);


 
?>