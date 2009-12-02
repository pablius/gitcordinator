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
	protected $hard_delete = true;
	
	// definimos los attr del objeto
	public $tag;
	public $class_relacion;
	public $id_relacion;
	public $id_project;
	
	public function name()
	{
		return $this->get('tag');
	}
	
	// @optmize (certain cases of string might not get linked)
	static public function link_tags($string, project_project $project)
	{
		global $ari;
		$string_array = explode(' ', $string);
		$public_url = $project->public_url();
		$i = 0;
		foreach ($string_array as $possible)
		{
			if (substr($possible,0,1) == '#')
			{
				if ($tag = static::from_name(substr($possible,1,strlen($possible)),$project))
				{	
					$name = $tag->name();
					$string_array[$i] = "<a href=\"{$public_url}/project/browse/tag/{$name}\">#{$name}</a>";
				}
			}
			$i++;
		}
		
		return implode (' ',$string_array);
	}
	
	static public function from_name($string, project_project $project)
	{
		global $ari;
		
		$string = $ari->db->qMagic($string);
		$id_project = $ari->db->qMagic($project->id());
		
		// here we are limiting the query as we can have many records, but if one is found, we consider the tag to exist
		$result = static::getList(0, 1, false, false, false, false, false, "AND tag = $string and id_project = $id_project");
		
		if ($result != false && count($result) == 1)
		{
			return $result[0];
		}
		else
		{
			return false;
		}
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


