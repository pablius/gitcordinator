<?php
/**
########################################
#OOB/N1 Framework [©2004,2006]
#
#  @copyright Pablo Micolini
#  @license BSD
######################################## 
*/

if (!seguridad :: isAllowed(seguridad_action :: nameConstructor('update','role','seguridad')) )
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
		$role = new seguridad_role ($handle[2]);
		$ari->t->assign("id", $handle[2] );
	}
	
}
else
{
 	throw new OOB_exception("INVALID_ID_VALUE", "501", "INVALID_ID_VALUE", false);	
}

$ari->t->assign("chkAllUsers", "" );
$ari->t->assign("checked_users", "" );

if (isset ($handle[3]))
{ 
	if (trim(strtolower($handle[3])) == "allusers" )
	{
		$ari->t->assign("checked_users", "checked" );
		if($usuarios = seguridad_role::searchNoMembers('',DELETED,OPERATOR_DISTINCT,$role,USER))
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
			$ari->t->assign("checked_users", "" );
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
		$role->delete();
		header( "Location: " . $ari->get("adminaddress") . '/seguridad/role/list'); 
		exit;
	}

}

$ari->t->assign("new_description", "" );
$ari->t->assign("new_name", "" );
$ari->t->assign("search_text_user", "" );
$ari->t->assign("checked_anonymous", "" );
$ari->t->assign("checked_trustees", "" );
 
if ( !isset ($_POST['update'] )  )
{
   $ari->t->assign("error", false );
   $ari->t->assign("new_name", $role->get("name") );
   $ari->t->assign("new_description", $role->get("description") );
   if ($role->get("anonymous") == ANONIMO)
   {	
   		$ari->t->assign("checked_anonymous", "checked" );
   		$ari->t->assign("flag_anonymous", true );	
   }
   else
   {	
   		$ari->t->assign("checked_anonymous", "" );	
   		$ari->t->assign("flag_anonymous", false );
   }

   if ($role->get("trustees") == YES)
   {	$ari->t->assign("checked_trustees", "checked" );   }
   else
   {	$ari->t->assign("checked_trustees", "" );   		}
			
  	if (isset ($_POST['description']))
	{
		$role->set ('description', $_POST['description']);
		$ari->t->assign("new_description", $_POST['description'] );
	}
	if (isset ($_POST['name']))
	{
		$role->set ('name', $_POST['name']);
		$ari->t->assign("new_name", $_POST['name'] );
	}
 	
 	//Adds the selected users
    if(isset ($_POST['AddUser']) && isset($_POST['users_select']) )
  	{
		//verificar datos enviados duplicados
		if(!$sp->Validar())
		{	$ari->t->assign('error', true);
			$ari->t->assign('SENT_DUPLICATE_DATA', true);
		}
		else
		{
			$ari->db->StartTrans();
			foreach($_POST['users_select'] as $id_user)
			{
				$tmpUser = new oob_user($id_user);
				$role->addUser($tmpUser);
			}
			$ari->db->CompleteTrans();
	  		//$ari->clearCache();
		}

  	}// end if isset

	//Removes the selected users
  	if(isset ($_POST['DelUser']) && isset($_POST['users_members_select']) )
  	{
		//verificar datos enviados duplicados
		if(!$sp->Validar())
		{	$ari->t->assign('error', true);
			$ari->t->assign('SENT_DUPLICATE_DATA', true);
		}
		else
		{
			$ari->db->StartTrans();
			foreach($_POST['users_members_select'] as $id_user)
			{
				$tmpUser = new oob_user($id_user);
				$role->removeUser($tmpUser);
			}
			$ari->db->CompleteTrans();
	  		//$ari->clearCache();
		}
			
  	}// end if isset

 	//Adds the selected groups
    if(isset ($_POST['AddGroup']) && isset($_POST['groups_select']) )
  	{
		//verificar datos enviados duplicados
		if(!$sp->Validar())
		{	$ari->t->assign('error', true);
			$ari->t->assign('SENT_DUPLICATE_DATA', true);
		}
		else
		{
			$ari->db->StartTrans();
			foreach($_POST['groups_select'] as $id_group)
			{
				$tmpGroup = new seguridad_group($id_group);
				$role->addGroup($tmpGroup);
			}
			$ari->db->CompleteTrans();
	 		//$ari->clearCache();	
		}
		
  	}// end if isset
	
	//Removes the selected groups
  	if(isset ($_POST['DelGroup']) && isset($_POST['group_members_select']) )
  	{	
		//verificar datos enviados duplicados
		if(!$sp->Validar())
		{	$ari->t->assign('error', true);
			$ari->t->assign('SENT_DUPLICATE_DATA', true);
		}
		else
		{
			$ari->db->StartTrans();
			foreach($_POST['group_members_select'] as $id_group)
			{
				$tmpGroup = new seguridad_group($id_group);
				$role->removeGroup($tmpGroup);
			}
			$ari->db->CompleteTrans();
	 		//$ari->clearCache();	
		}
		
  	}// end if isset
  
 	//Adds the selected modules
    if(isset ($_POST['AddModule']) && isset($_POST['modules_select']) )
  	{
		//verificar datos enviados duplicados
		if(!$sp->Validar())
		{	$ari->t->assign('error', true);
			$ari->t->assign('SENT_DUPLICATE_DATA', true);
		}
		else
		{
			if ($_POST['modules_select'] != "")
			{
				$tmpModule = new OOB_module($_POST['modules_select']);
				$role->addModule($tmpModule);
			}
	  		//$ari->clearCache();
	 	}
		
  	}// end if isset  
  
	//Removes the selected modules
  	if(isset ($_POST['DeleteModules']) && isset($_POST['DeleteListModule']) )
  	{	
 		//verificar datos enviados duplicados
		if(!$sp->Validar())
		{	$ari->t->assign('error', true);
			$ari->t->assign('SENT_DUPLICATE_DATA', true);
		}
		else
		{
			$ari->db->StartTrans();
			foreach($_POST['DeleteListModule'] as $id_module)
			{
				$tmpModule = new OOB_module($id_module);
				$role->removeModule($tmpModule);
			}
			$ari->db->CompleteTrans();
			//$ari->clearCache();
		}
		
  	}// end if isset  
  	
  	//Updates the selected actions
  	if(isset ($_POST['UpdateActions']) )
  	{	
 		//verificar datos enviados duplicados
		if(!$sp->Validar())
		{	$ari->t->assign('error', true);
			$ari->t->assign('SENT_DUPLICATE_DATA', true);
		}
		else
		{
			$ari->db->StartTrans();
			if ($role->removeActions())
			{
				if(isset ($_POST['ActionValue']) )
				{
					foreach($_POST['ActionValue'] as $id_action)
					{
						$a = new seguridad_action($id_action);
						$role->addAction($a);
					}
				}
			}
			if ($ari->db->CompleteTrans())
			{	$ari->clearCache('menu');
			}
		}
		
  	}// end if isset  
 
    //search users no members with SearchTextUser 
  	if(isset ($_POST['SearchUser']) && isset($_POST['SearchTextUser']) )
  	{
  		$cadena = trim(htmlentities($_POST['SearchTextUser'],0,"UTF-8"));
		$ari->t->assign("search_text_user", $cadena );
		
  		if ($cadena !="")
  		{
  			if($usuarios = seguridad_role::searchNoMembers($cadena,DELETED,OPERATOR_DISTINCT,$role,USER))
  			{
				$i = 0;
				$return = array();
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
  	
  	//list users members
	if($usuarios_miembros = seguridad_role::listUsersFor($role))
	{
		$i = 0;
		$return = array();
		foreach ($usuarios_miembros as $m)
		{
			$return[$i]['id']= $m->get('user');
			$return[$i]['uname']= $m->get('uname');
			
			if ($m->get('employee'))
			{
				$return[$i]['ename']= $m->get('employee')->name();
			}
			else
			{	
				$return[$i]['ename']= "Anonimo";
			}//end if
			
			++$i;
		}
		$ari->t->assign("usuarios_miembros", $return );
	}//end if

	if($grupos = seguridad_role::searchNoMembers('',DELETED,OPERATOR_DISTINCT,$role,GROUP))
  	{
		$i = 0;
		$return = array();
		foreach ($grupos as $g)
		{
			$return[$i]['id']= $g->get('group');		
			$return[$i]['name']= $g->get('name');
			++$i;
		}
		$ari->t->assign("grupos", $return );
  	}//end if	

	if($modules = seguridad_role::searchNoMembers('',DELETED,OPERATOR_DISTINCT,$role,MODULE))
  	{
		$i = 0;
		$return = array();
		foreach ($modules as $m)
		{
			$return[$i]['nicename']= $m->nicename();		
			$return[$i]['id']= $m->name();
			++$i;
		}

		$ari->t->assign("modules", $return );
  	}//end if	

  	//search groups members
	if($grupos_miembros = seguridad_role::listGroupsFor($role))
	{
		$i = 0;
		$return = array();
		foreach ($grupos_miembros as $m)
		{
			$return[$i]['id']= $m->get('group');
			$return[$i]['name']= $m->get('name');
			++$i;
		}
		$ari->t->assign("grupos_miembros", $return );
	}//end if

  	//search modules members
  	$ari->t->assign("modules_members", "" );
  	
	if($modules_members = seguridad_role::listModulesFor($role, true))
	{
		$i = 0;
		$return = array();
		foreach ($modules_members as $m)
		{
			$return[$i] = array();
			$return[$i]['id']= $m->name();
			$return[$i]['nicename']= $m->nicename();
					
			if ($return[$i]['permissions'] = seguridad_permission :: listPermissionsFor($m))
			{
				$tmparray = array();
				$j = 0;
				foreach ($return[$i]['permissions'] as $p)
				{			
					$tmparray[$j]['id'] = $p->get("permission");
					$tmparray[$j]['name'] = $p->get("name");
					$tmparray[$j]['nicename'] = $p->get("nicename");
															
					//search actions
					$array_acciones = array();
					if ($tmparray[$j]['acciones'] = seguridad_action :: listActionsFor($p, ALL_MENU) )
					{
						$k = 0;
						
						foreach($tmparray[$j]['acciones'] as $a)
						{
							$array_acciones[$k]['id'] = $a->get("action");
							$array_acciones[$k]['name'] = $a->get("name");
							$array_acciones[$k]['nicename'] = $a->get("nicename");

							if ( seguridad_action :: exists($a,$role) )
							{
								$value = CHECKED;
							}
							else
							{
								$value = UNCHECKED;
							}
							$array_acciones[$k]['value'] = $value;
							
							$k++;
						}
						
					}
					$tmparray[$j]['acciones'] = $array_acciones;
					$j++;
				}
				
				$return[$i]['permissions'] = $tmparray;
			}
			++$i;
		}
		
		$ari->t->assign("modules_members", $return );
		
	}//end if
	
 
 } // end !isset-update
 else 
 {
 	//update
	//verificar datos enviados duplicados
	if(!$sp->Validar())
	{	$ari->error->addError ('seguridad_role', 'SENT_DUPLICATE_DATA');
	}

 	if (OOB_validatetext :: isNumeric ($_POST['id']))
	 {$role = new seguridad_role($_POST['id']);}
 	else
 	{throw new OOB_exception("INVALID_ID_VALUE", "501", "INVALID_ID_VALUE", false);}
 	
 	
 	if (isset ($_POST['description']))
	{
		$role->set ('description', $_POST['description']);
		$ari->t->assign("new_description", $_POST['description'] );
	}
	if (isset ($_POST['name']))
	{
		$role->set ('name', $_POST['name']);
		$ari->t->assign("new_name", $_POST['name'] );
	}
	
	$role->set ('anonymous', NO_ANONIMO);
	
	if (isset ($_POST['anonymous_check']))
	{
		$role->set ('anonymous', ANONIMO);
	}
	
	$role->set ('trustees', NO);
	
	if (isset ($_POST['trustees_check']))
	{
		$role->set ('trustees', YES);
	}
		
		
	$role->set ('status', USED);
	
   // stores user data
	if ($role->store()) 
	{ 	
		header( "Location: " . $ari->get("adminaddress") . '/seguridad/role/list'); 
  		exit;
  	}
  	
	$ari->t->assign("error", true );
	$ari->t->assign("INVALID_NAME", false );
	$ari->t->assign("DUPLICATE_ROLE", false );
  
	$errores = $ari->error->getErrorsfor("seguridad_role");

	foreach ($errores as $error)
		$ari->t->assign($error, true );
	  	
}

$ari->t->assign("formElement", $sp->FormElement());
$ari->t->display($ari->module->admintpldir(). "/role_update.tpl");	
?>

