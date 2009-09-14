<?
/* we'll receive all off stories from the dashboard and update accordingly.
   This MUST BE optimized
*/
$ari->popup = true;
$result["data"] = array();
$result["success"] = true;

if (
	isset($_POST['current'])
	&&
	isset($_POST['pb'])
	&&
	isset($_POST['unplanned'])
	)
{
	
	$current_array = explode('&', str_replace('story[]=','',$_POST['current']));
	$pb_array = explode('&', str_replace('story[]=','',$_POST['pb']));
	$unplanned_aray = explode('&', str_replace('story[]=','',$_POST['unplanned']));
	
	// we reverse it to go from the bottom and up
	$sorted_array = array_reverse(array_merge($current_array,$pb_array,$unplanned_aray));
		
	$relevance_number = project_story::max_relevance_number($project);
	
	$current_sprint = $project->current_sprint();
	$product_backlog = $project->product_backlog(); 
	$unplanned = $project->unplaned();
	
	foreach ($sorted_array as $story_number)
	{
		if($story = project_story::number_constructor($story_number,$project))
		{
			$story->set('relevance',$relevance_number);
			$relevance_number--;
			
			if (in_array($story_number,$current_array))
			{
				$story->set('sprint',$current_sprint);
			}
			elseif (in_array($story_number,$pb_array))
			{
				$story->set('sprint',$product_backlog);
			}
			else
			{
				$story->set('sprint',$unplanned);
			}
			
			if (!$story->store())
			{
				$result["success"] = false;
			}
		}
	}
	
	$result["data"]['current_sprint_count'] = $current_sprint->total_estimate();
	$result["data"]['pb_count'] = $product_backlog->total_estimate();
	$result["data"]['unplaned_count'] = $unplanned->total_estimate();

}
else
{
	$result["success"] = false;
}

// RESULTADO
$obj_comunication = new OOB_ext_comunication();
$obj_comunication->set_message("");
$obj_comunication->set_code("200");
$obj_comunication->set_data($result);

$obj_comunication->send(true,true);	

?>