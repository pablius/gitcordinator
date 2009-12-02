<?php
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/

// OOB_module :: includeClass ('seguridad', 'seguridad_role');

if (!seguridad :: isAllowed(seguridad_action :: nameConstructor('list','role','seguridad')) )
{
	throw new OOB_exception("Acceso Denegado", "403", "Acceso Denegado. Consulte con su Administrador!", true);
} 

// get roles
global $ari;
$handle = $ari->url->getVars();
$sp = new oob_safepost ("list");

$allowNew = seguridad :: isAllowed(seguridad_action :: nameConstructor('new','role','seguridad'));
$ari->t->assign('allowNew', $allowNew);

$allowDelete = seguridad :: isAllowed(seguridad_action :: nameConstructor('delete','role','seguridad'));
$ari->t->assign('allowDelete', $allowDelete);

$ari->t->caching = 0; // dynamic content 

// check the delete selector, and delete if selected
if (isset ($_POST['delete_submit']) && isset($_POST['selected_roles']))
{
	//verificar datos enviados duplicados
	if(!$sp->Validar())
	{	$ari->t->assign('error', true);
		$ari->t->assign('SENT_DUPLICATE_DATA', true);
	}
	else
	{
		$ari->db->StartTrans();
		foreach($_POST['selected_roles'] as $id_rol)
		{
			$rol = new seguridad_role($id_rol);
			$rol->delete();		
		}
		if ($ari->db->CompleteTrans())
		{	$ari->clearCache();
		}
	}
}
 	
// @todo set the amount so we know the "page", need a page drawer :(

// finally get the data
$return = array();
if ($roles = seguridad_role::listRoles(DELETED,"name",OPERATOR_DISTINCT)) {

	// show time
	$i = 0;
	foreach ($roles as $r)
	{
		$return[$i]['id']= $r->get('role');
		$return[$i]['name']= $r->get('name');
		$return[$i]['description']= $r->get('description');
		$return[$i]['status']= seguridad_role::getStatus($r->get('status'));
		++$i;
	}
	
}
$ari->t->assign("roles", $return );

$ari->t->assign("formElement", $sp->FormElement());
// display
$ari->t->display($ari->module->admintpldir(). "/role_list.tpl");
 
?>