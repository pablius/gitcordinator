<?php
//tag (tag, id, object, project_id) (object can be history or commit)
class project_tag extends OOB_model_type
{

	static protected $public_properties = array(
	
		'tag' 				=> 'isClean,isCorrectLength-0-140',
		'class_relacion'	=> 'isClean,isCorrectLength-0-255',
		'id_relacion'		=> 'object-relation',
		'id_project'		=> 'object-project_project'
		
	); // property => constraints
	
	static protected $table = 'project_tag';
	static protected $class = __CLASS__;	
	static $orders = array('tag'); 
	
	// definimos los attr del objeto
	public $tag;
	public $class_relacion;
	public $id_relacion;
	public $id_project;
	
	public function name()
	{
		return $this->get('tag');
	}
	
	static public function project_tag_cloud(project_project $project)
	{
		global $ari;
		// return is as follows => name,count,size
		$output = array();
		$return = array();
		$global_count = 0;
		
		if ($tags = project_tag::getRelated($project))
		{
			foreach ($tags as $tag)
			{
				$filtros = array();
				$filtros[] = array("field"=>"status","type"=>"list","value"=>1);
				$filtros[] = array("field"=>"project","type"=>"list","value"=>$project->id());
				$filtros[] = array("field"=>"tag","type"=>"string","value"=>$tag->name());
				
				$name = $tag->name();
				$count = project_tag::getFilteredListCount($filtros);
				
				if ((float)$count > (float)$global_count)
				{
					
					$global_count = $count;
				}
				
				$return[$name]['name'] = $name;
				$return[$name]['count'] = $count;
			}
			
			// sorted alfabetically
			ksort ($return);
			
			foreach ($return as $key => $data)
			{
				
				$relative_count = ($data['count'] / $global_count) * 100;
				
				
				if ($relative_count >= 0 && $relative_count < 20)
				{
					$size = 'x-small';
				}elseif($relative_count >= 20 && $relative_count < 40)
				{
					$size = 'small';
				}elseif($relative_count >= 40 && $relative_count < 60)
				{
					$size = 'medium';
				}elseif($relative_count >= 60 && $relative_count < 80)
				{
					$size = 'large';
				}else
				{
					$size = 'x-large';
				}
				
				$output[] = array ('name' => $key, 'count' => $data['count'], 'size' => $size);
			}
			
		
		}
		
		return $output;
	}
	
}
?>


