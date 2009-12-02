<h1 align="center" class="titulo2">Actualizar Rol</h1>
<script language="javascript" type="text/javascript" src="{$webdir}/scripts/functionsjs/functionsjs.js">
</script>
<form name="new" method="post" action="{$webdir}/seguridad/role/update/{$id}">
{$formElement}
 
{if $error}
	   <div class="error">
         <ul><font class="error">Error:</font>
         {if $INVALID_NAME}     
			<li>El Nombre del Rol no es v&aacute;lido.</li>
         {/if}
         {if $INVALID_DESCRIPTION}     
			<li>La Descripci&oacute;n del Rol no es v&aacute;lida.</li>
         {/if}
		 {if $DUPLICATE_ROLE}     
	        <li>Ya existe un Rol con el mismo Nombre.</li>
         {/if}

		{if $SENT_DUPLICATE_DATA}
			<li>Los datos de este fomulario ya han sido enviados para su procesamiento.</li>
		{/if}
		 
         </ul>
  </div>
{/if}

<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" colspan="2">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
        <tr class="cuadro-arriba">
          <td colspan="2" class="texto1">Nombre</td>
          </tr>
        <tr class="cuadro-abajo">
          <td width="3%" height="28">&nbsp;</td>
          <td width="97%"><input name="name" type="text" value="{$new_name}" size="40"></td>
        </tr>
      </table>
	  <br />
	  <br />
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
        <tr class="cuadro-arriba">
          <td colspan="2" class="texto1">Descripci&oacute;n</td>
          </tr>
        <tr class="cuadro-abajo">
          <td width="3%" height="88">&nbsp;</td>
          <td width="97%"><textarea name="description" cols="50" rows="5">{$new_description}</textarea></td>
        </tr>
      </table></td>
 </tr>
 <tr>
	<td colspan="2">&nbsp;</td>
 </tr>
 <tr>
	<td class="lista1">
      <input name="anonymous_check" type="checkbox" value="1" {$checked_anonymous}>
      <span class="texto4"> An&oacute;nimo </span></td>
	<td class="lista1">
      <input name="trustees_check" type="checkbox" value="1" {$checked_trustees}>
      <span class="texto4">      Incluir en la lista de Confiados</span> </td>
 </tr>
</table>
<div align="center"><br />
  <input name="id" type="hidden" value="{$id}">
  <input name="update" type="submit" id="update" value="Actualizar">
  <input name="cancel" type="button" id="cancel" value="Cancelar">
  <input name="delete" type="submit" id="delete" value="Borrar Rol">
  
</div>
<table width="100%"  border="0">
  <tr>
    <td valign="top">

    <p>{if !$flag_anonymous}    </p>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
      <tr class="cuadro-arriba">
        <td colspan="2" class="texto1">Agregar Usuarios: </td>
      </tr>
      <tr>
        <td width="4%" class="cuadro-abajo">&nbsp;</td>
        <td width="96%" class="cuadro-abajo"><input name="SearchTextUser" type="text" value="{$search_text_user}" onkeyup="enabledButton('new','SearchTextUser','SearchUser')" />
            <input name="SearchUser" type="submit" id="SearchUser" value="Buscar" disabled /></td>
      </tr>
    </table>
    <br />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lista1">
      <tr>
        <td height="20"><input type="checkbox" name="chkAllUsers" value="1" {$checked_users} onclick="refresh('{$webdir}/seguridad/role/update/{$id}','new','chkAllUsers','users_select[]')" />
          <span class="texto4">Mostrar Todos</span></td>
      </tr>
      <tr>
        <td height="20"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="43%" class="error">Usuarios No Miembros </td>
            <td width="10%" class="lista1">&nbsp;</td>
            <td width="47%" class="error">Usuarios Miembros </td>
          </tr>
          <tr class="lista1">
            <td class="cuadro-abajo"><select name="users_select[]" size="10" multiple="multiple" >
              
                
                		    
				{section name=u loop=$usuarios}
				 
                
                
              <option value="{$usuarios[u].id}">{$usuarios[u].uname}</option>
              
                
                
				{sectionelse}
				
                
                
              <option value="-1">--- No se encontraron resultados ---</option>
              
                
                
				{/section}
			
              
              
            </select>
                </p>
                <br />
                <a href="javascript:todo('users_select[]',true)" class="boton1" >&lt;&lt;Seleccionar todo&gt;&gt;</a> <a href="javascript:todo('users_select[]',false)" class="boton2" ><span class="boton2">&lt;&lt;Deseleccionar&gt;&gt;</span></td>
            <td class="cuadro-abajo"><p>
                <input name="AddUser" type="submit" id="AddUser" value="--&gt;" />
              </p>
                <p>
                  <input name="DelUser" type="submit" id="DelUser" value="&lt;--" />
              </p></td>
            <td class="cuadro-abajo"><select name="users_members_select[]" size="10" multiple="multiple" >
              
                
                
				{section name=m loop=$usuarios_miembros}
				 
                
                
              <option value="{$usuarios_miembros[m].id}">{$usuarios_miembros[m].ename} ({$usuarios_miembros[m].uname})</option>
              
                
                
				{sectionelse}
				
                
                
              <option value="-1">--- No se encontraron miembros ---</option>
              
                
                
				{/section}				
			
              
              
            </select>
                </p>
              <a href="javascript:todo('users_members_select[]',true)" class="boton1" >&lt;&lt;Seleccionar todo&gt;&gt;</a> <a href="javascript:todo('users_members_select[]',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a></td>
          </tr>
        </table></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
      <tr class="cuadro-arriba">
        <td colspan="3" class="texto1">Agregar Grupos: </td>
      </tr>
      <tr>
        <td width="46%" class="cuadro-abajo"><span class="error">Grupos No Miembros
          </span>
          <p>
            <select name="groups_select[]" size="10" multiple >
              		    
				{section name=g loop=$grupos}
				 
              <option value="{$grupos[g].id}">{$grupos[g].name}</option>
              
				{sectionelse}
				
              <option value="-1">--- No se encontraron resultados ---</option>
              
				{/section}
			
            </select>
          </p>
          <a href="javascript:todo('groups_select[]',true)" class="boton1" >&lt;&lt;Seleccionar todo&gt;&gt;</a> <a href="javascript:todo('groups_select[]',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a></td>
        <td width="8%" class="cuadro-abajo"><input name="AddGroup" type="submit" id="AddGroup" value="-->">
			</p>
			<p>
			<input name="DelGroup" type="submit" id="DelGroup" value="<--">			
			</td>
        <td width="46%" class="cuadro-abajo"><span class="error">Grupos Miembros
        </span>
          <p>
			<select name="group_members_select[]" size="10" multiple >
				{section name=m loop=$grupos_miembros}
				 <option value="{$grupos_miembros[m].id}">{$grupos_miembros[m].name}</option>
				{sectionelse}
				<option value="-1">--- No se encontraron miembros ---</option>
				{/section}				
			</select>
</p>
			<a href="javascript:todo('group_members_select[]',true)" class="boton1" >&lt;&lt;Seleccionar todo&gt;&gt;</a>				
			<a href="javascript:todo('group_members_select[]',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    
    <p>{/if}</p>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
  <tr class="cuadro-arriba">
    <td colspan="2" class="texto1">Agregar M&oacute;dulos: </td>
  </tr>
  <tr>
    <td width="4%" height="35" class="cuadro-abajo">&nbsp;</td>
    <td width="96%" class="cuadro-abajo"><select name="modules_select" >
				<option value="-1">--- Seleccione el m&oacute;dulo ---</option>
				{section name=m loop=$modules}
			    <option value="{$modules[m].id}">{$modules[m].nicename}</option>
				{/section}				
			</select>
			&nbsp;
			<input name="AddModule" type="submit" value="Agregar">
			<br />
			<table width="100%" border="0">
			  {section name=m loop=$modules_members}
			  <tr>
      <td colspan="3"><strong class="texto4">{$modules_members[m].nicename}</strong></td>
			    <td colspan="2"><div align="right"><strong>
          <input name="DeleteListModule[]" type="checkbox" id="DeleteListModule[]" value="{$modules_members[m].id}" />
			      <span class="error">Quitar</span></strong></div></td>
			    </tr>
			  {section name=p loop=$modules_members[m].permissions}
  <tr>
    <td width="5%"></td>
    <td width="48%" colspan="3"><strong class="texto-boton">{$modules_members[m].permissions[p].nicename}</strong></td>
  </tr>
			  {section name=a loop=$modules_members[m].permissions[p].acciones}
  <tr>
    <td width="5%"></td>
    <td width="5%"></td>
    <td colspan="2" ><strong>
      <input name="ActionValue[]" type="checkbox" id="ActionValue[]" value="{$modules_members[m].permissions[p].acciones[a].id}" {$modules_members[m].permissions[p].acciones[a].value} />
      <span class="texto4">      {$modules_members[m].permissions[p].acciones[a].nicename}</span></strong></td>
  </tr>
			  {sectionelse}
  <tr>
    <td width="5%"></td>
    <td width="5%"></td>
    <td width="48%" colspan="3" class="error">No se encontraron acciones</td>
  </tr>
			  {/section}
			  {sectionelse}
  <tr>
    <td width="5%"></td>
    <td width="48%" colspan="3" class="error">No se encontraron permisos</td>
  </tr>
			  {/section}
			  
			  {sectionelse}
  <tr>
    <td colspan="5" class="error"> No se encontraron m&oacute;dulos miembros. </td>
  </tr>
			  {/section}
		    </table>			</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%">
	<tr>
	<td>
			<p class="error">
       				M&oacute;dulos Miembros</p>	
			  <a href="javascript:ChequearTodos('ActionValue[]','new',true)" class="boton1" >&lt;&lt;Seleccionar todo&gt;&gt;</a>				
			<a href="javascript:ChequearTodos('ActionValue[]','new',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a>&nbsp;
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input name="UpdateActions" type="submit" id="UpdateActions" value="Actualizar acciones"></td>
                <td><div align="right">
                  <input name="DeleteModules" type="submit" id="DeleteModules2" value="Quitar los m&oacute;dulos seleccionados">
                </div></td>
              </tr>
            </table>	
	</table></td>
  </tr>
</table>
<br>
<input name="BackButton" type="button" value="Volver" onClick="history.back()"> 
</form>