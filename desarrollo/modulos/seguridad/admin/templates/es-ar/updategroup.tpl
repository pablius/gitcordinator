<h1 align="center" class="titulo2">Actualizar  Grupo de Usuarios</h1>
<script language="javascript" type="text/javascript" src="{$webdir}/scripts/functionsjs/functionsjs.js">
</script>

<form name="new" method="post" action="{$webdir}/seguridad/group/update/{$id}">
  <table width="100%"  border="0">
  <tr>
    <td valign="top">
{if $error}
	   <div class="error">
         <ul><font class="error">Error:</font>
         {if $INVALID_NAME}     <li>Debe ingresar el nombre del grupo de usuarios</li>{/if}
		 {if $DUPLICATE_GROUP}     <li>Ya existe un grupo de usuarios con el mismo nombre</li>{/if}
         </ul>
       </div>
        {/if} <br />
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
          <tr class="cuadro-arriba">
            <td colspan="2" class="texto1">Nombre</td>
          </tr>
          <tr class="cuadro-abajo">
            <td width="4%" height="28">&nbsp;</td>
            <td width="96%"><input name="name" type="text" value="{$new_name}">
      </td>
          </tr>
        </table>
        <br />
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
          <tr class="cuadro-arriba">
            <td colspan="2" class="texto1">Descripci&oacute;n</td>
          </tr>
          <tr class="cuadro-abajo">
            <td width="4%" height="89">&nbsp;</td>
            <td width="96%"><textarea name="description" cols="50" rows="5">{$new_description}</textarea>
</td>
          </tr>
        </table>
        <br />
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
          <tr class="cuadro-arriba">
            <td colspan="2" class="texto1">Agregar Usuarios: </td>
          </tr>
          <tr class="cuadro-abajo">
            <td width="4%">&nbsp;</td>
            <td width="96%"><table width="100%">
	<tr>

	</tr>
	<tr>
	<td >
	  <input name="SearchText" type="text" value="{$search_text}" onKeyUp="enabledButton('new','SearchText','Search')">
	  <input name="Search" type="submit" id="Search" value="Buscar" disabled >
	</td>
	</tr>
	<tr>
	<td class="texto4" ><input type="checkbox" name="chk_todos" value="1" {$checked} onClick="refresh('{$webdir}/seguridad/group/update/{$id}','new','chk_todos','users_select[]')">
	    Mostrar Todos </td>
	</tr>
	<tr>
	<TD colspan="2">
			
			<span class="error">No Miembros			</span>
			<p>
			<select name="users_select[]" size="10" multiple >		    
				{section name=u loop=$usuarios}
				 <option value="{$usuarios[u].id}">{$usuarios[u].uname}</option>
				{sectionelse}
				<option value="-1">--- No se encontraron resultados ---</option>
				{/section}
			</select>
</p>
			<a href="javascript:todo('users_select[]',true)" class="boton1" >&lt;&lt;Seleccionar todo&gt;&gt;</a>				
			<a href="javascript:todo('users_select[]',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a>		</TD>
	<TD width="13%">
			<p>
<input name="Add" type="submit" id="Add" value="-->">

			</p>
			<p>
			<input name="Del" type="submit" id="Del" value="<--">			
			</p>
			
	</TD>
	<TD width="43%">
	
			<span class="error">Miembros            </span>
			<p>
			<select name="members_select[]" size="10" multiple >
				{section name=m loop=$miembros}
				 <option value="{$miembros[m].id}">{$miembros[m].uname}</option>
				{sectionelse}
				<option value="-1">--- No se encontraron miembros ---</option>
				{/section}				
			</select>
</p>
			<a href="javascript:todo('members_select[]',true)" class="boton1" >&lt;&lt;Seleccionar todo&gt;&gt;</a>				
			<a href="javascript:todo('members_select[]',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a></TD>
	</tr>
	</table></td>
          </tr>
        </table>
        <h2 align="center">
          <input name="id" type="hidden" value="{$id}">
              <input name="update" type="submit" id="update" value="Actualizar">
	          <input name="cancel" type="button" id="cancel" value="Cancelar">
	          <input name="delete" type="submit" id="delete" value="Borrar Grupo">
      </h2>
      </td>
  </tr>
</table>

</form>