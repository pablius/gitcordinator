<?php
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/

//OOB_module :: includeClass("seguridad", "seguridad_group");

if (!seguridad :: isAllowed(seguridad_action :: nameConstructor('new','group','seguridad')) )
{
	throw new OOB_exception("Acceso Denegado", "403", "Acceso Denegado. Consulte con su Administrador!", true);
} 
 
global $ari;
$sp = new oob_safepost ("new");

$ari->t->assign("new_description", "" );
$ari->t->assign("new_name", "" );

if (!isset ($_POST['ok']))
{	
	$ari->t->assign("error", false );  	
} 
else 
{
 
 	$grupo = new seguridad_group();
	
	//verificar datos enviados duplicados
	if(!$sp->Validar())
	{	$ari->error->addError ('seguridad_group', 'SENT_DUPLICATE_DATA');
	}
	
	if (isset ($_POST['description']))
	{
		$grupo->set ('description', $_POST['description']);
		$description = OOB_validatetext :: inputHTML($_POST['description']);
		$ari->t->assign("new_description", $description );
	}
	if (isset ($_POST['name']))
	{
		$grupo->set ('name', $_POST['name']);
		$name = OOB_validatetext :: inputHTML($_POST['name']);
		$ari->t->assign("new_name", $name );
	}
	
	$grupo->set ('status', 1);
	
// stores?

	if ($grupo->store()) 
	{ 
		header( "Location: " . $ari->get("adminaddress") . '/seguridad/group/update/' . $grupo->get('group')); 
  		exit;
	}
	
	$ari->t->assign("error", true );
	$ari->t->assign("INVALID_NAME", false );
	$ari->t->assign("DUPLICATE_GROUP", false );
  
	$errores = $ari->error->getErrorsfor("seguridad_group");

	foreach ($errores as $error)
		$ari->t->assign($error, true );
   
}

$ari->t->assign("formElement", $sp->FormElement());
$ari->t->display($ari->module->admintpldir(). "/group_new.tpl"); 
?>
