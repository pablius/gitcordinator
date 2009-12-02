<?php
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/
if (!seguridad :: isAllowed(seguridad_action :: nameConstructor('update','user','seguridad')) )
{
	throw new OOB_exception("Acceso Denegado", "403", "Acceso Denegado. Consulte con su Administrador!", true);
}  
 
global $ari;
$handle = $ari->url->getVars();
$ari->t->caching = false;
$sp = new oob_safepost ("update");

// validamos el ID, o modificamos el usuario actual
$usuario = $ari->user;

if (isset ($handle[2]) && OOB_validatetext :: isNumeric ($handle[2]))
{ 
	if (seguridad :: isAllowed(seguridad_action :: nameConstructor('update','user','seguridad')))
		{$usuario = new oob_user ($handle[2]);}
		else
		{
			throw new OOB_exception("Acceso Denegado", "403", "Acceso Denegado. Consulte con su Administrador!", true);
		}
}

 // no butto get, standard action
  if (!isset ($_POST['update']))
 {
   $ari->t->assign("error", false );
   $ari->t->assign("uname", $usuario->get("uname") );
   $ari->t->assign("id", $usuario->get("user") );
   $ari->t->assign("email", $usuario->get("email") );
   
   
	$ari->t->assign("status_values",oob_user::getStatus());
	$ari->t->assign("status_names",oob_user::getStatus());
	$ari->t->assign("status",oob_user::getStatus($usuario->get("status"), true));
 
 }
 else 
 {
 	
	if (OOB_validatetext :: isNumeric ($_POST['id']))
	 {$usuario = new oob_user($_POST['id']);}
 	else
 	{throw new OOB_exception("INVALID_ID_VALUE", "501", "INVALID_ID_VALUE", false);}

	//verificar datos enviados duplicados
	if(!$sp->Validar())
	{	$usuario->error()->addError ('SENT_DUPLICATE_DATA');
	}
 	
 
 	if ($_POST['user_pass'] != "" && $_POST['passtwo'] != "")
 	{$usuario->set ('password', $_POST['user_pass']);}
 
 $usuario->set ('email', $_POST['email']);
 
 $status = oob_user::getStatus($_POST['status_select'], false);
 $usuario->set ('status', $status );

// stores user data
if ($_POST['user_pass'] === $_POST['passtwo'])
	{
	if ($usuario->store()) 
		{ 
		if (seguridad :: isAllowed(seguridad_action :: nameConstructor('update','user','seguridad')))	
		{header( "Location: " . $ari->get("adminaddress") . '/seguridad/user/list/' . $_POST['status_select'] . '/uname');}
		else
		{header( "Location: " . $ari->get("adminaddress") . '/');} 
  		exit;
  		
  		}
	}

// no se pudo grabar, hay un error!
  $ari->t->assign("error", true );
  
  $errores = $usuario->error()->getErrors();
  
   if ($_POST['user_pass'] !== $_POST['passtwo'])
   $errores[] = "NO_CONCUERDAN";
  
 foreach ($errores as $error)
	 $ari->t->assign($error, true );
  
	
   
   $ari->t->assign("uname", OOB_validatetext :: inputHTML($_POST['user_name']));
   
   $ari->t->assign("id", $_POST['id'] );
   
   $ari->t->assign("status_values",oob_user::getStatus());
   $ari->t->assign("status_names",oob_user::getStatus());
   $ari->t->assign("status", $_POST['status_select'] );
  
  //if (!in_array ("INVALID_EMAIL", $errores))
   $ari->t->assign("email", OOB_validatetext :: inputHTML($_POST['email']));
  
}

$ari->t->assign("formElement", $sp->FormElement());
$ari->t->display($ari->module->admintpldir(). "/user_update.tpl"); 
?>
