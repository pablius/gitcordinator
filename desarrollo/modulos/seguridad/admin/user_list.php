<?php
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/

if (!seguridad :: isAllowed(seguridad_action :: nameConstructor('list','user','seguridad')) )
{
	throw new OOB_exception("Acceso Denegado", "403", "Acceso Denegado. Consulte con su Administrador!", true);
} 

// get users
global $ari;
$handle = $ari->url->getVars();
$ari->t->caching = 0; // dynamic content 
$sp = new oob_safepost ("list");

$allowUpdate = seguridad :: isAllowed(seguridad_action :: nameConstructor('update','user','seguridad'));
$ari->t->assign('allowUpdate', $allowUpdate);

// check the selector, and redirects if selected
if (isset ($_POST['kind_submit']) && in_array($_POST['kind_select'], oob_user::getMethods()) &&  in_array($_POST['kind_order'], oob_user::getOrders()))
{	
	
	$path = "";
	if( isset($_POST['text']) && $_POST['text'] <> "" && OOB_validatetext::isClean($_POST['text']) )
	{	$path = "/" . OOB_validatetext::inputHTML($_POST['text']);
	}
	header( "Location: " . $ari->get("adminaddress") . '/seguridad/user/list/' . $_POST['kind_select'] . '/' .$_POST['kind_order'] . $path);
	exit;
}

// check the search button, and redirects if selected
if(isset($_POST['search']) && isset($_POST['text']) && $_POST['text'] <> "")
{
	$path = "";
	if (in_array($_POST['kind_select'], oob_user::getMethods()) &&  in_array($_POST['kind_order'], oob_user::getOrders()))
	{	$path = $_POST['kind_select'] . '/' .$_POST['kind_order'];
	}
	else
	{	$path = "enabled/uname";
	}
	//var_dump($_POST);exit;
	if(OOB_validatetext::isClean($_POST['text']) )
	{	$path.= "/" . OOB_validatetext::inputHTML($_POST['text']);
	}

	header( "Location: " . $ari->get("adminaddress") . '/seguridad/user/list/' . $path);
	exit;
	
}

// check the user update status selector, and update if selected
if (isset ($_POST['select_submit']) && isset($_POST['selected_users']))
{
	//verificar datos enviados duplicados
	if(!$sp->Validar())
	{	$ari->t->assign('error', true);
		$ari->t->assign('SENT_DUPLICATE_DATA', true);
	}
	else
	{
		oob_user::updateStatusFor ($_POST['selected_users'],$_POST['change_select']);
		header( "Location: " . $ari->get("adminaddress") . '/seguridad/user/list/' . $_POST['change_select'] . '/uname');
	}
	
}


// set the get method
if (!isset($handle[2]) || (!in_array($handle[2], oob_user::getMethods())))
{$handle[2] = "enabled";}
$ari->t->assign("method", $handle[2] );

// set the order
if (!isset($handle[3]) || (!in_array($handle[3], oob_user::getOrders())))
{$handle[3] = "uname";}
$ari->t->assign("order",$handle[3]);

//search text
if (isset($handle[4]) && OOB_validatetext::isClean($handle[4]))
{	$text = urldecode($handle[4]);
	$ari->t->assign("text",OOB_validatetext::inputHTML($text));
}
else
{	$text = "";
	$ari->t->assign("text",false);
}

$ari->t->assign("order",$handle[3]);


//selectors data
$ari->t->assign("kind_values",oob_user::getMethods());
$ari->t->assign("kind_names",oob_user::getMethods());
$ari->t->assign("change_values",oob_user::getStatus());


// @todo set the amount so we know the "page", need a page drawer :(
// valida pos
$pos = 0;
if (isset($_GET['pos']) && OOB_validatetext::isNumeric($_GET['pos']) && $_GET['pos'] > 0)
	{	$pos = $_GET['pos'];}


	
//levanta el limit
$limit = $ari->module->config()->get('limit', 'user');
$ari->t->assign ('limit',$limit);
$ari->t->assign ('total',oob_user::searchCount($handle[2], $text));

// finally get the data
if ($usuarios = oob_user::search($handle[2], $handle[3], $text, $pos, $limit)) 
{	// show time
	$i = 0;
	foreach ($usuarios as $u)
	{
		$return[$i]['id']= $u->get('user');
		$return[$i]['uname']= $u->get('uname');
		$return[$i]['email']= $u->get('email');
		$return[$i]['status']= oob_user::getStatus($u->get('status'));
		++$i;
	}
	$ari->t->assign("usuarios", $return );
}
$ari->t->assign("formElement", $sp->FormElement());
// display
 $ari->t->display($ari->module->admintpldir(). "/user_list.tpl");
?>
