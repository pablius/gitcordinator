<?php
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/
 
global $ari;
$sp = new oob_safepost ("new");

if (!seguridad :: isAllowed(seguridad_action :: nameConstructor('new','role','seguridad')) )
{
	throw new OOB_exception("Access Denied", "403", "Access Denied!", true);
}

$ari->t->assign("new_description", "" );
$ari->t->assign("new_name", "" );
$ari->t->assign("checked_anonymous", "" );
$ari->t->assign("checked_trustees", "" );

if (!isset ($_POST['ok']))
{
	$ari->t->assign("error", false );  	
} 
else 
{
	//verificar datos enviados duplicados
	if(!$sp->Validar())
	{	$ari->error->addError ('seguridad_role', 'SENT_DUPLICATE_DATA');
	}

 	$role = new seguridad_role();

	if (isset ($_POST['description']))
	{
		$role->set ('description', $_POST['description']);
		$description = OOB_validatetext :: inputHTML($_POST['description']);
		$ari->t->assign("new_description", $description);
	}
	if (isset ($_POST['name']))
	{
		$role->set ('name', $_POST['name']);
		$name = OOB_validatetext :: inputHTML($_POST['name']);
		$ari->t->assign("new_name", $name);
	}
	if (isset ($_POST['anonymous_check']))
	{
		$role->set ('anonymous', $_POST['anonymous_check']);
		if ($_POST['anonymous_check'] = ANONIMO)
		{	$ari->t->assign("checked_anonymous", "checked" );	}
		else
		{	$ari->t->assign("checked_anonymous", "" );	}
	}
	if (isset ($_POST['trustees_check']))
	{
		$role->set ('trustees', $_POST['trustees_check']);
		if ($_POST['trustees_check'] = YES)
		{	$ari->t->assign("trustees_anonymous", "checked" );	}
		else
		{	$ari->t->assign("trustees_anonymous", "" );	}
	}	
	$role->set ('status', USED);
	
// stores?

	if ($role->store()) 
	{ 
		header( "Location: " . $ari->get("adminaddress") . '/seguridad/role/update/' . $role->get('role')); 
  		exit;
	}
	
	$ari->t->assign("error", true );
	$ari->t->assign("INVALID_NAME", false );
	$ari->t->assign("INVALID_DESCRIPTION", false );
	$ari->t->assign("DUPLICATE_ROLE", false );
  
	$errores = $ari->error->getErrorsfor("seguridad_role");

	foreach ($errores as $error)
		$ari->t->assign($error, true );
  
   
}

$ari->t->assign("formElement", $sp->FormElement());
$ari->t->display($ari->module->admintpldir(). "/role_new.tpl"); 

?>
