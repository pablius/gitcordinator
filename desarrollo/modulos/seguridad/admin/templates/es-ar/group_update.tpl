<h1 align="center" class="titulo2">Actualizar  Grupo de Usuarios</h1>
<script language="javascript" type="text/javascript" src="{$webdir}/scripts/functionsjs/functionsjs.js">
</script>


<form name="new" method="post" action="{$webdir}/seguridad/group/update/{$id}">
{$formElement} 



{if $error}
	   <div class="error">
         <ul><font class="error">Error:</font>
         {if $INVALID_NAME}<li>Debe ingresar el nombre del grupo de usuarios</li>{/if}
		 {if $INVALID_DESCRIPTION}<li>La descripci&oacute;n para el grupo de usuarios no es v&aacute;lida.</li>
		 {/if}
		 {if $DUPLICATE_GROUP}<li>Ya existe un grupo de usuarios con el mismo nombre</li>{/if}

		 {if $SENT_DUPLICATE_DATA}
			 <li>Los datos de este fomulario ya han sido enviados para su procesamiento.</li>
		 {/if}

		 
         </ul>
       </div>
{/if}

<hr class="barra">  

<table width="100%"  border="0">
  <tr>
    <td valign="top">


	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
        <tr class="cuadro-arriba">
          <td colspan="2"><span class="texto1">Nombre</span></td>
        </tr>
        <tr class="cuadro-abajo">
          <td width="2%" height="27" valign="middle">	    </td>
          <td width="98%" valign="middle"><input name="name" type="text" value="{$new_name}"></td>
        </tr>
      </table>
	  <br />
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
        <tr class="cuadro-arriba">
          <td colspan="2"><span class="texto1">Descripci&oacute;n </span></td>
        </tr>
        <tr class="cuadro-abajo">
          <td width="2%" height="102" valign="middle">	</td>
          <td width="98%" valign="middle"><textarea name="description" cols="50" rows="5">{$new_description}</textarea></td>
        </tr>
      </table>
	  <br />
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
        <tr class="cuadro-arriba">
          <td colspan="2"><span class="texto1">Agregar Usuarios: </span></td>
        </tr>
        <tr class="cuadro-abajo">
          <td width="2%" height="29">&nbsp;</td>
          <td width="98%"><input name="SearchText" type="text" value="{$search_text}" onKeyUp="enabledButton('new','SearchText','Search')">
	  <input name="Search" type="submit" id="Search" value="Buscar" disabled ></td>
        </tr>
      </table>
	  <br />
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
        <tr class="cuadro-arriba">
          <td width="46%"><input type="checkbox" name="chk_todos" value="1" {$checked} onClick="refresh('{$webdir}/seguridad/group/update/{$id}','new','chk_todos','users_select[]')">
	    <span class="texto4">Mostrar Todos </span></td>
          <td width="6%">&nbsp;</td>
          <td width="48%">&nbsp;</td>
        </tr>
        <tr>
          <td class="cuadro-abajo"><span class="error">No Miembros			</span>
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
			<a href="javascript:todo('users_select[]',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a>		</td>
          <td valign="middle" class="cuadro-abajo"><p>
<input name="Add" type="submit" id="Add" value="-->">

			</p>
			<p>
			<input name="Del" type="submit" id="Del" value="<--">			
			</p></td>
          <td class="cuadro-abajo"><span class="error">Miembros            </span>
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
			<a href="javascript:todo('members_select[]',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
	  <h2 align="center">
	    <input name="id" type="hidden" value="{$id}">
              <input name="update" type="submit" id="update" value="Actualizar">
	          <input name="delete" type="submit" id="delete" value="Borrar Grupo">
			  <input name="BackButton" type="button" value="Volver" onClick="history.back()"> 
      </h2>
	  </td>
  </tr>
</table>

</form>