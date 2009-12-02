<?php
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/

//OOB_module :: includeClass ("seguridad", "seguridad_group");
 
if (!seguridad :: isAllowed(seguridad_action :: nameConstructor('update','group','seguridad')) )
{
	throw new OOB_exception("Acceso Denegado", "403", "Acceso Denegado. Consulte con su Administrador!", true);
} 
 
global $ari;
$handle = $ari->url->getVars();
$ari->t->caching = false;
$sp = new oob_safepost ("update");

if (isset ($handle[2]))
{ 
	if (OOB_validatetext :: isNumeric ($handle[2]) )
	{
		$grupo = new seguridad_group ($handle[2]);
		$ari->t->assign("id", $handle[2] );
	}
	
}
else
{
 	throw new OOB_exception("INVALID_ID_VALUE", "501", "INVALID_ID_VALUE", false);	
}

$ari->t->assign("checked", "" );
if (isset ($handle[3]))
{ 
	if (trim(strtolower($handle[3])) == "allusers" )
	{
		$ari->t->assign("checked", "checked" );
		if($usuarios = seguridad_group::searchNoMembers('',DELETED,OPERATOR_DISTINCT,$grupo))
		{
			$i = 0;
			foreach ($usuarios as $u)
			{
				$return[$i]['id']= $u->get('user');
				$return[$i]['uname']= $u->get('uname');
				++$i;
			}
			$ari->t->assign("usuarios", $return );
		}//end if
	}
	else
	{
			$ari->t->assign("checked", "" );
	}
	
}

if (isset ($_POST['delete']))
{
	//verificar datos enviados duplicados
	if(!$sp->Validar())
	{	$ari->t->assign('error', true);
		$ari->t->assign('SENT_DUPLICATE_DATA', true);
	}
	else
	{
		$grupo->delete();
		header( "Location: " . $ari->get("adminaddress") . '/seguridad/group/list'); 
		exit;
	}
}

$ari->t->assign("new_description", "" );
$ari->t->assign("new_name", "" );
$ari->t->assign("search_text", "" );
$ari->t->assign("checked_todos", "" );
 
if ( !isset ($_POST['update'] )  )
 {
   $ari->t->assign("error", false );
   $ari->t->assign("new_name", $grupo->get("name") );
   $ari->t->assign("new_description", $grupo->get("description") );
   
   
    if(isset ($_POST['Add']) && isset($_POST['users_select']) )
  	{
  		$ari->db->StartTrans();
  		foreach($_POST['users_select'] as $id_user)
  		{
  			$tmpUser = new oob_user($id_user);
  			$grupo->addUser($tmpUser);
  		}
  		$ari->db->CompleteTrans();
  	}// end if isset
  	
  	
  	
  	  	if(isset ($_POST['Del']) && isset($_POST['members_select']) )
  	{
  		$ari->db->StartTrans();
  		foreach($_POST['members_select'] as $id_user)
  		{
  			$tmpUser = new oob_user($id_user);
  			$grupo->removeUser($tmpUser);
  		}
  		$ari->db->CompleteTrans();
  	}// end if isset
   
    //search no members with SearchText 
  	if(isset ($_POST['Search']) && isset($_POST['SearchText']) )
  	{
  		$ari->t->assign("search_text", $_POST['SearchText'] );
	  	if (isset ($_POST['description']))
		{
			$grupo->set ('description', $_POST['description']);
			$ari->t->assign("new_description", $_POST['description'] );
		}
		if (isset ($_POST['name']))
		{
			$grupo->set ('name', $_POST['name']);
			$ari->t->assign("new_name", $_POST['name'] );
		}
  	
  		$cadena = trim($_POST['SearchText']);

  		if ($cadena !="")
  		{
  			if($usuarios = seguridad_group::searchNoMembers($cadena,DELETED,OPERATOR_DISTINCT,$grupo))
  			{
				$i = 0;
				foreach ($usuarios as $u)
				{
					$return[$i]['id']= $u->get('user');
					$return[$i]['uname']= $u->get('uname');
					++$i;
				}
				$ari->t->assign("usuarios", $return );
  			}//end if
  			
  		}//end if
  	}// end if isset
  	
	if( $miembros = seguridad_group::listUsersFor($grupo) )
	{
		$i = 0;
		$return = array();
		foreach ($miembros as $m)
		{
			$return[$i]['id']= $m->get('user');
			$return[$i]['uname']= $m->get('uname');
			++$i;
		}
		$ari->t->assign("miembros", $return );
	}//end if

 
 }else {
 	//update
 	
	//verificar datos enviados duplicados
	if(!$sp->Validar())
	{	$ari->error->addError ('seguridad_group', 'SENT_DUPLICATE_DATA');
	}

	if (OOB_validatetext :: isNumeric ($_POST['id']))
	 {$grupo = new seguridad_group($_POST['id']);}
 	else
 	{throw new OOB_exception("INVALID_ID_VALUE", "501", "INVALID_ID_VALUE", false);}
 	
 	
 	if (isset ($_POST['description']))
	{
		$grupo->set ('description', $_POST['description']);
		$ari->t->assign("new_description", $_POST['description'] );
	}
	if (isset ($_POST['name']))
	{
		$grupo->set ('name', $_POST['name']);
		$ari->t->assign("new_name", $_POST['name'] );
	}
	
	$grupo->set ('status', 1);
	
   // stores user data
	if ($grupo->store()) 
	{ 
		header( "Location: " . $ari->get("adminaddress") . '/seguridad/group/list'); 
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
 $ari->t->display($ari->module->admintpldir(). "/group_update.tpl");
?>
