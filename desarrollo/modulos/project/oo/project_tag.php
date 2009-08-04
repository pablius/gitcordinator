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
	
	static public function tag_cloud (project_project $project)
	{}
	
	public function name()
	{
		return $this->get('tag');
	}
	
}
?>


