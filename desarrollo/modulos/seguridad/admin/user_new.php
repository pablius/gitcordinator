<?php
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/
if (!seguridad :: isAllowed(seguridad_action :: nameConstructor('new','user','seguridad')) )
{
	throw new OOB_exception("Acceso Denegado", "403", "Acceso Denegado. Consulte con su Administrador!", true);
}  

  global $ari;
	$ari->t->caching = 0; // dynamic content 
  
$sp = new OOB_safepost ("login");


 // no butto get, standard action
  if (!isset ($_POST['register']))
 {
	  $ari->t->assign("newname", "");
	  $ari->t->assign("newemail", "");
	  $ari->t->assign("error", false );
//	  $ari->t->assign("formElement", $sp->FormElement());
//	  $ari->t->display($ari->module->admintpldir(). "/user_new.tpl");
 
 } 
 else 
 {
 
	 $unusuario = new oob_user();
	 $unusuario->set ('uname', $_POST['newname']);
	 $unusuario->set ('password', $_POST['password']);
	 $unusuario->set ('email', $_POST['newemail']);
	 $unusuario->set ('status', "1"); //  @optimize: posiblemente esto tenga q ser un selector?

 	 if(!$sp->Validar())
		{ $unusuario->error()->addError('SENT_DUPLICATE_DATA');}

		
	if ($_POST['password'] !== $_POST['passtwo'])
		{ $unusuario->error()->addError('NO_CONCUERDAN');}
	
	if ($unusuario->store()) 
		{ 
			header( "Location: " . $ari->get("adminaddress") . '/seguridad/user/list'); 
			exit;
		} 
	else	
		{
			$errores = $unusuario->error()->getErrors();
		}

	
		
	 $ari->t->assign("error", true );
		  
		
		  
	 foreach ($errores as $error)
		 {	$ari->t->assign($error, true );	 }
	  
	 if (!in_array ("INVALID_USER", $errores))
	 {	$ari->t->assign("newname", OOB_validatetext :: inputHTML($_POST['newname']));
	 }
	  
	if (!in_array ("INVALID_EMAIL", $errores))
	 {	$ari->t->assign("newemail", OOB_validatetext :: inputHTML($_POST['newemail']));
	 }
	   
 }
 	   
$ari->t->assign("formElement", $sp->FormElement());
$ari->t->display($ari->module->admintpldir(). "/user_new.tpl");


?>
