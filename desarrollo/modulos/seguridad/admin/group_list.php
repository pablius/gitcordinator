<?php
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/
 
// OOB_module :: includeClass ("seguridad", "seguridad_group");
 
if (!seguridad :: isAllowed(seguridad_action :: nameConstructor('list','group','seguridad')) )
{
	throw new OOB_exception("Acceso Denegado", "403", "Acceso Denegado. Consulte con su Administrador!", true);
} 

 
// get groups
global $ari;
$handle = $ari->url->getVars();
$ari->t->caching = 0; // dynamic content 
$sp = new oob_safepost ("list");

$allowNew = seguridad :: isAllowed(seguridad_action :: nameConstructor('new','role','seguridad'));
$ari->t->assign('allowNew', $allowNew);

$allowDelete = seguridad :: isAllowed(seguridad_action :: nameConstructor('delete','role','seguridad'));
$ari->t->assign('allowDelete', $allowDelete);

// check the user update status selector, and update if selected
if (isset ($_POST['delete_submit']) && isset($_POST['selected_groups']))
{
	//verificar datos enviados duplicados
	if(!$sp->Validar())
	{	$ari->t->assign('error', true);
		$ari->t->assign('SENT_DUPLICATE_DATA', true);
	}
	else
	{
		$ari->db->StartTrans();
		foreach($_POST['selected_groups'] as $id_grupo)
		{
			$grupo = new seguridad_group($id_grupo);
			$grupo->delete();		
		}
		$ari->db->CompleteTrans();
	}
}
 	
// @todo set the amount so we know the "page", need a page drawer :(

// finally get the data
$return = array();
if ($groups = seguridad_group::listGroups(DELETED,"name",OPERATOR_DISTINCT)) {

	// show time
	$i = 0;
	foreach ($groups as $g)
	{
		$return[$i]['id']= $g->get('group');
		$return[$i]['name']= $g->get('name');
		$return[$i]['description']= $g->get('description');
		$return[$i]['status']= seguridad_group::getStatus($g->get('status'));
		++$i;
	}
	
}
$ari->t->assign("groups", $return );

$ari->t->assign("formElement", $sp->FormElement());
// display
$ari->t->display($ari->module->admintpldir(). "/group_list.tpl");
 
 
?>
