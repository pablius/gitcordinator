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

// si el usuario está activo, lo redirigimos a donde le corresponda
 if (is_a($ari->user, 'oob_user'))
 { 
	if (isset ($_SESSION['redirecting']))
 	{
		$dire = $_SESSION['redirecting'];
		unset ($_SESSION['redirecting']);
		header( "Location: " . $ari->get("webaddress") . $dire  ); 
}
 	else
 	{
		$default_login = $ari->get('config')->get('defaultlogin', 'main');
		header( "Location: " . $ari->get('webaddress') . $default_login);
	}
	
	exit;
 } 

 $ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR."pending.tpl");

?>
