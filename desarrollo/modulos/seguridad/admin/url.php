<?
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/

/*
Url Handler for SECURITY MODULE (admin)

*/


global $ari;
$handle = $ari->url->getVars();

switch ($handle[0])
{ //--

case "login": 
{
	include ($ari->module->admindir() . DIRECTORY_SEPARATOR  . "login.php");
	break;
}

case "logout": 
{
	if (!is_a($ari->user, 'oob_user'))
	{
		header( "Location: " . $ari->get("adminaddress") . '/');
		exit; 
	} 	
	$ari->user->logout();
	break;
}	

case "permission": 
case "action":
case "role": 
case "user":
case "group":
{
	if (isset ($handle[1]) && file_exists ($ari->module->admindir() . DIRECTORY_SEPARATOR  . $handle[0] . "_" .$handle[1] . ".php"))
	{include ($ari->module->admindir() . DIRECTORY_SEPARATOR  . $handle[0] . "_" . $handle[1] . ".php");}
	else
	{include ($ari->module->admindir() . DIRECTORY_SEPARATOR  . $handle[0] . "_list.php");}
	break;
}

case "":
{
//	include ($ari->module->admindir() . DIRECTORY_SEPARATOR  . "role_list.php");
break;
}


default:
{
	throw new OOB_exception('', "404", 'Revise que la dirección ingresada sea correcta.');	
	break;
}

}//-- end switch

?>